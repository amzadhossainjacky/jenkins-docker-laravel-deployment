<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Str;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * LearningMaterialService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class LearningMaterialService
{
    /**
     * get_learning_material_lists method returns list of learning materials
     * @return collection
     */
    public function get_learning_material_lists()
    {
        return LearningMaterial::orderBy('id', 'DESC');
    }

    /**
     * create methods returns create resource
     * @param array $inputs
     * @return \App\Models\LearningMaterial
     */
    public function create(array $inputs): LearningMaterial
    {
        $data = [
            'user_id' => Auth::id(),
            'title' => $inputs['title'],
            'description' => $inputs['description'],
            'is_active' => $inputs['is_active'],
        ];

        $model_created = LearningMaterial::Create($data);

        if (isset($inputs['attachment'])) {
            ## Upload files/attachments
            foreach ($inputs['attachment'] as $key => $attachment) {
                $disk = "attachments";
                $directory = "learning_materials";
                $uuid = (string) Str::uuid();
                $now = date('Ymdhis');
                $extension = $attachment->getClientOriginalExtension();
                $file_name = _str_conversion(pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME), 'strtolower', true, false);
                $original_file_name = _str_conversion($file_name, 'strtolower', false, true) . ".{$extension}";
                $file = _str_conversion("{$file_name}_{$now}_{$uuid}.{$extension}", 'strtolower', false, true);

                $single_attachment_array = [
                    "file" => "{$directory}/{$file}",
                    "extension" => $extension,
                    "original_file_name" => $original_file_name,
                ];
                ## Upload to local disk
                $attachment->storeAs($directory, $file, $disk);

                ## Create new attachment
                $new_attachment = new Attachment($single_attachment_array);
                $model_created->attachment()->save($new_attachment);
            }
        }


        return $model_created;
    }

    /**
     * edit learning material
     * @param array $id
     * @return \App\Models\LearningMaterial
     */
    public function edit($id): LearningMaterial
    {
        $data = LearningMaterial::with('attachment')->find($id);
        return $data;
    }

    /**
     * update learning material
     * @param array $inputs
     */
    public function update($inputs, $id)
    {
        $data = [
            'user_id' => Auth::id(),
            'title' => $inputs['title'],
            'description' => $inputs['description'],
            'is_active' => $inputs['is_active'],
        ];

        $model_updated = LearningMaterial::find($id);
        $model_updated->fill($data);
        $model_updated->save();

        if (isset($inputs['attachment'])) {
            ## Upload files/attachments
            foreach ($inputs['attachment'] as $key => $attachment) {
                $disk = "attachments";
                $directory = "learning_materials";
                $uuid = (string) Str::uuid();
                $now = date('Ymdhis');
                $extension = $attachment->getClientOriginalExtension();
                $file_name = _str_conversion(pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME), 'strtolower', true, false);
                $original_file_name = _str_conversion($file_name, 'strtolower', false, true) . ".{$extension}";
                $file = _str_conversion("{$file_name}_{$now}_{$uuid}.{$extension}", 'strtolower', false, true);

                $single_attachment_array = [
                    "file" => "{$directory}/{$file}",
                    "extension" => $extension,
                    "original_file_name" => $original_file_name,
                ];
                ## Upload to local disk
                $attachment->storeAs($directory, $file, $disk);

                ## Create new attachment
                $new_attachment = new Attachment($single_attachment_array);
                $model_updated->attachment()->save($new_attachment);
            }
        }

        return $model_updated;
    }

    /**
     * remove attachment
     * @param array $inputs
     */
    public function remove_attachment($id, $attachment_id)
    {
        $disk = "attachments";
        $existing_file = Attachment::find($attachment_id);

        if ($existing_file) {
            if (Storage::disk($disk)->exists($existing_file->file)) {
                Storage::disk($disk)->delete($existing_file->file);
            }

            Attachment::destroy($attachment_id);
        }
    }
}
