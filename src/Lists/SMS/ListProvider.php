<?php namespace SamJoyce777\Marketing\Lists\SMS;

abstract class ListProvider
{
    protected $title;

    protected $description;

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getList($options)
    {
        $query = $this->query($options);

        return $query->toArray();
    }

    public function getCount($options)
    {
        $query = $this->query($options);

        return $query->count();
    }

    public function getSql($options)
    {
        $query = $this->query($options);

        return $query->toSql();
    }
}
