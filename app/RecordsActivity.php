<?php
/**
 * Created by PhpStorm.
 * User: Ibrahim
 * Date: 16/09/2017
 * Time: 23:35
 */

namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {

        if (auth()->guest()) return;
        foreach (static::getActivitiesToRecord() as $event) {
            static::created(function ($newActivity) use ($event) {
                $newActivity->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
//            dd(get_class($model));
            $model->activity()->delete();

        });

    }


    public static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($eventType)
    {
        // This
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($eventType)
        ]);
        //Replace This
//        Activity::create([
//            'user_id' => auth()->id() ? auth()->id() : 0,
//            'type' => $this->getActivityType($eventType),
//            'subject_id' => $this->id,
//            'subject_type' => get_class($this)
//        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @param $eventType
     * @return string
     */
    protected function getActivityType($eventType)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $eventType . '_' . $type;
    }
}