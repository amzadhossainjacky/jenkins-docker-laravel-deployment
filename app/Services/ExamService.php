<?php

namespace App\Services;

use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * ExamService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamService
{
    /**
     * get_exam_lists method returns list of exams
     * @return collection
     */
    public function get_exam_lists()
    {
        return Exam::orderBy('id', 'DESC');
    }

    /**
     * create methods returns create resource
     * @param array $inputs
     * @return \App\Models\Exam
     */
    public function create(array $inputs): Exam
    {
        $model_created = Exam::Create(
            $inputs
        );

        return $model_created;
    }

    /**
     * edit exam 
     * @param array $id
     * @return \App\Models\Exam
     */
    public function edit($id): Exam
    {
        $model = Exam::find($id);
        return $model;
    }

    /**
     * update exam
     * @param array $inputs
     * @return \App\Models\Exam
     */
    public function update($inputs, $id): Exam
    {
        $model_updated = Exam::find($id);
        $model_updated->fill($inputs);
        $model_updated->save();

        return $model_updated;
    }
}
