<?php namespace SamJoyce777\Marketing\EmailCreators;

interface EmailCreatorInterface
{
    public function getTitle():string;

    public function getDescription():string;

    public function getTemplate():string;

    public function getSenderEmail():string;

    public function getSenderName():string;

    public function getSubject():string;

    public function getTags():array;

    public function getMeta():array;

    public function getHTML():?string;
}