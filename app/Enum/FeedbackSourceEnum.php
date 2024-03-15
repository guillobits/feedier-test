<?php
namespace App\Enum;


enum FeedbackSourceEnum:string
{
    case DASHBOARD = 'dashboard';
    case EXTERNAL = 'external';
}
