<?php

namespace App\Admin\Controllers;

use App\Models\TaskCallbackSrv;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskCallbackSrvController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TaskCallbackSrv';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TaskCallbackSrv());

        $grid->filter(function($filter) {
            $filter->like('name', __('Name'));        
        });

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->column('name', __('Name'));
        $grid->column('checked_health_at', __('Checked health at'))->display(function($val) {
            if ($val == 0) {
                return "";
            }
            return date("Y-m-d H:i:s", $val);
        });
        $grid->column('has_enable_health_check', __('Has enable health check'))->display(function($val) {
            if ($val > 0) {
                return __('yes');
            }

            return __('no');
        });
        $grid->disableCreateButton(true);
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
              $actions->disableDelete();
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });

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
        $show = new Show(TaskCallbackSrv::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('name', __('Name'));
        $show->field("checked_health_at", __("Checked health at"))->as(function($val) {
            if ($val == 0) {
                return "";
            }
            return date("Y-m-d H:i:s", $val);
        });
        $show->field('has_enable_health_check', __('Has enable health check'))->as(function($val) {
            if ($val > 0) {
                return __('yes');
            }

            return __('no');
        });
        $show->routes(__('Routes'), function($val) {
            $val->disableCreateButton(true);
            $val->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
                });
            });
            $val->disableActions();
            $val->id();
            $val->srv_schema();
            $val->host();
            $val->port();
            $val->enable_health_check()->display(function($val) {
                if ($val > 0) {
                    return __('yes');
                }
    
                return __('no');
            });
            $val->callback_timeout_sec();
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
        $form = new Form(new TaskCallbackSrv());

        $form->text('name', __('Name'));
        $form->switch('has_enable_health_check', __('Has enable health check'));

        return $form;
    }
}
