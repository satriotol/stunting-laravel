<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\News;
use Encore\Admin\Admin;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News());

        $grid->column('id', __('Id'));
        $grid->column('category.name', __('Kategori'));
        $grid->column('user.name', __('Diupload Oleh'));
        if (Auth::user()->roles[0]->name == 'Operator') {
            $grid->column('verified_by', __('Verifikasi'))->default('Belum Diverifikasi');
        }else{
            $grid->column('verified_by', __('Verifikasi'))->editable('select',[1=>'Terima',2=>'Tolak']);
        }
        $grid->column('title', __('Judul'));
        $grid->column('date', __('Tanggal'));
        $grid->column('content', __('Konten'));
        $grid->column('image', __('Image'))->image();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(News::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Kategori'));
        $show->field('user_id', __('User id'));
        $show->field('verified_by', __('Verified by'));
        $show->field('title', __('Judul'));
        $show->field('date', __('Tanggal'));
        $show->field('content', __('Konten'));
        $show->field('image', __('Image'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new News());

        $form->select('category_id', __('Category'))->options(Category::all()->pluck('name','id'));
        $form->hidden('user_id', __('User id'));
        $form->hidden('verified_by', __('Verified by'));
        $form->text('title', __('Judul'));
        $form->date('date', __('Tanggal'))->default(date('Y-m-d'));
        $form->textarea('content', __('Konten'));
        $form->image('image', __('Image'));
        $form->submitted(function (Form $form) {
            $form->user_id = Auth::user()->id;
            if (Auth::user()->roles[0]->name != 'Operator') {
                $form->verified_by = 1;
            }else{
            }
        });
        return $form;
    }
}
