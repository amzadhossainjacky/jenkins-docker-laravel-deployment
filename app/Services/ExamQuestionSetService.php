<?php

namespace App\Services;

use App\Models\ExamQuestionSet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * ExamQuestionSetService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamQuestionSetService
{
    /**
     * get_exam_question_set_lists method returns list of exam question sets
     * @return collection
     */
    public function get_exam_question_set_lists()
    {
        return ExamQuestionSet::orderBy('id', 'DESC');
    }

    /**
     * create methods returns create resource
     * @param array $inputs
     * @return \App\Models\ExamQuestionSet
     */
    public function create(array $inputs): ExamQuestionSet
    {
        $model_created = ExamQuestionSet::Create(
            $inputs
        );

        return $model_created;
    }

    /**
     * edit exam question sets
     * @param array $id
     * @return \App\Models\ExamQuestionSet
     */
    public function edit($id): ExamQuestionSet
    {
        $model = ExamQuestionSet::find($id);
        return $model;
    }

    /**
     * update exam question sets
     * @param array $inputs
     * @return \App\Models\ExamQuestionSet
     */
    public function update($inputs, $id): ExamQuestionSet
    {
        $model_updated = ExamQuestionSet::find($id);
        $model_updated->fill($inputs);
        $model_updated->save();

        return $model_updated;
    }
}
