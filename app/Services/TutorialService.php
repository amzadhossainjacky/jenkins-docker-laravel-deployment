<?php

namespace App\Services;

use App\Models\LearningMaterial;

/**
 * TutorialService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class TutorialService
{
    /**
     * get_tutorial_lists method returns list of learning materials
     * @return collection
     */
    public function get_tutorial_lists()
    {
        return LearningMaterial::orderBy('id', 'DESC');
    } 
}
