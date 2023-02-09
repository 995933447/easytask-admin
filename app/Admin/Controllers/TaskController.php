<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use App\Models\TaskCallbackSrv;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Task';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task());

        $grid->filter(function($filter) {
            $filter->like('name', __('Name'));        
        });

        $grid->filter(function ($filter) {
            $filter->where(function ($query) {
                $srvId = TaskCallbackSrv::query()->where('name', 'like', "%{$this->input}%")->select('id')->get()->toArray();
                $query->whereIn('callback_srv_id', $srvId);
             }, __('Callback srv name'));
        });

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Stopped at'))->display(function($val) {
            if ($val == 0) {
                return "";
            }
            return date("Y-m-d H:i:s", $val);
        });
        $grid->column('name', __('Name'));
        $grid->column('arg', __('Arg'));
        $grid->column('last_run_at', __('Last run at'))->display(function($val) {
            if ($val == 0) {
                return "";
            }
            return date("Y-m-d H:i:s", $val);
        });
        $grid->column('sched_mode', __('Sched mode'))->display(function($val) {
            
            switch($val) {
                case Task::SCHED_MODE_CRON_EXPR:
                    return "cron:" . $this->time_cron_expr;
                case Task::SCHED_MODE_INTERVAL:
                    return "interval:" . $this->time_interval_sec . "s";
                case Task::SCHED_MODE_SPEC:
                    return "sepcified time:" . date("Y-m-d H:i:s", $this->plan_sched_next_at);
            };
        });
        $grid->column('server.name', __('Callback srv name'));
        // $grid->column('callback_srv_id', __('Callback srv id'));
        $grid->column('run_times', __('Run times'));
        $grid->column('allow_max_run_times', __('Allow max run times'))->display(function($val) {
            if ($val == 9223372036854775807) {
                return __("Not limit");
            }
            return $val;
        });
        // $grid->column('max_run_time_sec', __('Max run time sec'))->display(function($val) {
        //     if ($val == 0) {
        //         return __("Not limit");
        //     }
        //     return $val;
        // });
        // $grid->column('callback_path', __('Callback path'));
        $grid->column('biz_id', __('Biz id'));
        $grid->disableCreateButton(true);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show($task = Task::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Stopped at'))->date();
        $show->field('name', __('Name'));
        $show->field('arg', __('Arg'));
        $show->field('last_run_at', __('Last run at'))->as(function($val) {
            return date("Y-m-d H:i:s", $val);
        });
        $show->field('plan_sched_next_at', __('Plan sched next at'))->as(function($val) {
            return date("Y-m-d H:i:s", $val);
        });
        $show->field('sched_mode', __('Sched mode'))->as(function($val) use($task) {
            switch($val) {
                case Task::SCHED_MODE_CRON_EXPR:
                    return "cron:" . $task->time_cron_expr;
                case Task::SCHED_MODE_INTERVAL:
                    return "interval:" . $task->time_interval_sec . "s";
                case Task::SCHED_MODE_SPEC:
                    return "sepcify time:" . date("Y-m-d H:i:s", $task->plan_sched_next_at);
            }
        });
        $show->field('run_times', __('Run times'));
        $show->field('allow_max_run_times', __('Allow max run times'))->as(function($val) {
            if ($val == 9223372036854775807) {
                return __("Not limit");
            }
            return $val;
        });
        $show->field('max_run_time_sec', __('Max run time sec'))->as(function($val) {
            if ($val == 0) {
                return __("Not limit");
            }
            return $val;
        });
        $show->field('callback_path', __('Callback path'));
        $show->field('biz_id', __('Biz id'));
        $show->field('server.name', __('Callback server name'));
        $show->logs(__('Executed logs'), function($val) {
            $val->disableCreateButton(true);
            $val->disableActions();
            $val->id();
            $val->started_at()->sortable();
            $val->ended_at();
            $val->task_status()->display(function($val) {
                switch($val) {
                    case 2:
                        return __('Running');
                    case 3:
                        return __('Success');
                    case 4:
                        return __('Failed');
                }
                return __('Ready');
            });
            $val->is_run_in_async()->display(function($val) {
                if ($val > 0) {
                    return __('yes');
                }
    
                return __('no');
            });
            $val->run_times();
            $val->req_snapshot();
            $val->resp_snapshot()->display(function($val) {
                $respContent = "";
                if ($val != "") {
                    $respSnapshot = json_decode($val, true);
                    if (array_key_exists("resp_raw", $respSnapshot)) {
                        $respContent = $respSnapshot["resp_raw"];
                    };
                };
                return $respContent; 
            });
            $val->callback_err();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Task());

        $form->text('name', __('Name'));
        $form->textarea('arg', __('Arg'));
        $form->number('max_run_time_sec', __('Max run time sec'));
        $form->textarea('callback_path', __('Callback path'));
        $form->text('biz_id', __('Biz id'));

        return $form;
    }
}
