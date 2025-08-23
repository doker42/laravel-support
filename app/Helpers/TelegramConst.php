<?php

namespace App\Helpers;

class TelegramConst
{
    public const TYPE_INFO          = 'info';
    public const TYPE_ERROR         = 'error';
    public const TYPE_TARGET        = 'target';

    /**               p r o d               */
    /** telegram chat */
    public const SREDA_GROUP_INFO        = 'SredaInfo';
    public const SREDA_GROUP_ERROR       = 'SredaError';
    /** telegram bot */
    public const SREDA_BOT_INFO          = 'SredaInfo';
    public const SREDA_BOT_ERROR         = 'SredaError';


    /**                  t a r g e t                  */
    /** telegram chat */
//    public const SREDA_GROUP_ZOHO_CRM    = 'SredaZohoCrm';
//    public const SREDA_GROUP_ZOHO_DESK   = 'SredaZohoDesk';
    /** telegram bot */
//    public const SREDA_BOT_ZOHO_CRM      = 'SredaZohoCrm';
//    public const SREDA_BOT_ZOHO_DESK     = 'SredaZohoDesk';


    /**            d e v    l o c a l                   */
    /** telegram chat */
    public const SREDA_GROUP_INFO_TEST   = 'SredaInfoTest';
    public const SREDA_GROUP_ERROR_TEST  = 'SredaErrorTest';

    /** telegram bot */
    public const SREDA_BOT_INFO_TEST     = 'SredaInfoTest';
    public const SREDA_BOT_ERROR_TEST    = 'SredaErrorTest';



    /**            people  actions                   */

    public const WEBHOOK_PEOPLE_ACTION_ASSIST   = 'assist';
    public const WEBHOOK_PEOPLE_ACTION_PROJECTS = 'projects';
    public const WEBHOOK_PEOPLE_ACTION_PROJECT  = 'project';
    public const WEBHOOK_PEOPLE_ACTION_SURVEYS  = 'surveys';
    public const WEBHOOK_PEOPLE_ACTION_SEARCH   = 'search';



    /**           handlers   type                   */

    public const WEBHOOK_HANDLER_TYPE_COMMAND = 'bot_command';
    public const WEBHOOK_HANDLER_TYPE_ACTION  = 'action';
    public const WEBHOOK_HANDLER_TYPE_MESSAGE = 'message';



    public const WEBHOOK_MSG_ACT_ASSIST   = 'AI Assistant';
    public const WEBHOOK_MSG_ACT_PROJECTS = '<= Back';

}