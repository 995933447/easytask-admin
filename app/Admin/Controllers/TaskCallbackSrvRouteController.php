<?php

namespace App\Admin\Controllers;

use App\Models\TaskCallbackSrvRoute;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskCallbackSrvRouteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TaskCallbackSrvRoute';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TaskCallbackSrvRoute());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->column('host', __('Host'));
        $grid->column('port', __('Port'));
        $grid->column('srv_id', __('Srv id'));
        $grid->column('callback_timeout_sec', __('Callback timeout sec'));
        $grid->column('checked_health_at', __('Checked health at'));
        $grid->column('enable_health_check', __('Enable health check'));
        $grid->column('srv_schema', __('Srv schema'));
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
        $show = new Show(TaskCallbackSrvRoute::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('schema', __('Schema'));
        $show->field('host', __('Host'));
        $show->field('port', __('Port'));
        $show->field('srv_id', __('Srv id'));
        $show->field('callback_timeout_sec', __('Callback timeout sec'));
        $show->field('checked_health_at', __('Checked health at'));
        $show->field('enable_health_check', __('Enable health check'));
        $show->field('srv_schema', __('Srv schema'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TaskCallbackSrvRoute());

        $form->textarea('schema', __('Schema'));
        $form->text('host', __('Host'));
        $form->number('port', __('Port'));
        $form->number('srv_id', __('Srv id'));
        $form->number('callback_timeout_sec', __('Callback timeout sec'));
        $form->number('checked_health_at', __('Checked health at'));
        $form->switch('enable_health_check', __('Enable health check'));
        $form->text('srv_schema', __('Srv schema'));

        return $form;
    }
}
