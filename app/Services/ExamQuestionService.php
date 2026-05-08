<?php

namespace App\Services;

use App\Models\ExamQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * ExamService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamQuestionService
{
    /**
     * get_exam_question_lists method returns list of exam queations
     * @return collection
     */
    public function get_exam_question_lists()
    {
        return ExamQuestion::orderBy('id', 'DESC');
    }

    /**
     * create methods returns create resource
     * @param array $inputs
     * @return \App\Models\ExamQuestion
     */
    public function create(array $inputs): ExamQuestion
    {
        // $model_created = ExamQuestion::Create(
        //     $inputs
        // );

        // return $model_created;
    }

    /**
     * edit exam 
     * @param array $id
     * @return \App\Models\ExamQuestion
     */
    public function edit($id): ExamQuestion
    {
        // $model = ExamQuestion::find($id);
        // return $model;
    }

    /**
     * update exam
     * @param array $inputs
     * @return \App\Models\ExamQuestion
     */
    public function update($inputs, $id): ExamQuestion
    {
        // $model_updated = ExamQuestion::find($id);
        // $model_updated->fill($inputs);
        // $model_updated->save();

        // return $model_updated;
    }
}
