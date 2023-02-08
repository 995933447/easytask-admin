<?php

namespace App\Admin\Controllers;

use App\Models\TaskLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TaskLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TaskLog());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->column('task_id', __('Task id'));
        $grid->column('started_at', __('Started at'));
        $grid->column('ended_at', __('Ended at'));
        $grid->column('task_status', __('Task status'));
        $grid->column('is_run_in_async', __('Is run in async'));
        $grid->column('resp_extra', __('Resp extra'));
        $grid->column('try_times', __('Try times'));
        $grid->column('run_times', __('Run times'));
        $grid->column('srv_id', __('Srv id'));
        $grid->column('req_snapshot', __('Req snapshot'));
        $grid->column('resp_snapshot', __('Resp snapshot'));
        $grid->column('callback_err', __('Callback err'));

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
        $show = new Show(TaskLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('task_id', __('Task id'));
        $show->field('started_at', __('Started at'));
        $show->field('ended_at', __('Ended at'));
        $show->field('task_status', __('Task status'));
        $show->field('is_run_in_async', __('Is run in async'));
        $show->field('resp_extra', __('Resp extra'));
        $show->field('try_times', __('Try times'));
        $show->field('run_times', __('Run times'));
        $show->field('srv_id', __('Srv id'));
        $show->field('req_snapshot', __('Req snapshot'));
        $show->field('resp_snapshot', __('Resp snapshot'));
        $show->field('callback_err', __('Callback err'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TaskLog());

        $form->number('task_id', __('Task id'));
        $form->number('started_at', __('Started at'));
        $form->number('ended_at', __('Ended at'));
        $form->number('task_status', __('Task status'));
        $form->switch('is_run_in_async', __('Is run in async'));
        $form->textarea('resp_extra', __('Resp extra'));
        $form->number('try_times', __('Try times'));
        $form->number('run_times', __('Run times'));
        $form->number('srv_id', __('Srv id'));
        $form->textarea('req_snapshot', __('Req snapshot'));
        $form->textarea('resp_snapshot', __('Resp snapshot'));
        $form->textarea('callback_err', __('Callback err'));

        return $form;
    }
}
