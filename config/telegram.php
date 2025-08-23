<?php

use App\Helpers\TelegramConst;

return [
  /*
  |--------------------------------------------------------------------------
  | Your Telegram Bots
  |--------------------------------------------------------------------------
  | You may use multiple bots at once using the manager class. Each bot
  | that you own should be configured here.
  |
  | Here are each of the telegram bots config parameters.
  |
  | Supported Params:
  |
  | - name: The *personal* name you would like to refer to your bot as.
  |
  |       - username: Your Telegram Bot's Username.
  |                       Example: (string) 'BotFather'.
  |
  |       - token:    Your Telegram Bot's Access Token.
                      Refer for more details: https://core.telegram.org/bots#botfather
  |                   Example: (string) '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11'.
  |
  |       - commands: (Optional) Commands to register for this bot,
  |                   Supported Values: "Command Group Name", "Shared Command Name", "Full Path to Class".
  |                   Default: Registers Global Commands.
  |                   Example: (array) [
  |                       'admin', // Command Group Name.
  |                       'status', // Shared Command Name.
  |                       Acme\Project\Commands\BotFather\HelloCommand::class,
  |                       Acme\Project\Commands\BotFather\ByeCommand::class,
  |             ]
  */

    'bots' => [

        'Sreda' => [
            'username'  => 'SredaMainBot',
            'token'     => '6993119658:AAGndO-U3m6gsZrDkXN5gsqpTeLAJAmEXIQ',
            'name'      => 'SredaAi'
        ],

        'SredaAi' => [
            'username'  => 'SredaAiBot',
            'token'     => '6672909282:AAGgT2OUWEUqlTnFkd8d2eU4YYceuYvtSlo',
            'name'      => 'SredaAi'
        ],

        'SredaAiDev' => [
            'username'   => 'SredaAiDevBot',
            'token'      => '6749981669:AAGKN8loJXDeNvr9JItgVKcmHVVrLiuoUx8',
            'name'       => 'SredaAiDev',
        ],

        'SredaAiTest' => [
            'username'   => 'SredaAiTestBot',
            'token'      => '7057127351:AAE8U2b4Auc4oleEiWaJbRdLGUdy2us3O44',
            'name'       => 'SredaAiTest',
        ],

        'SredaInfo' => [
            'username'   => 'SredaInfo',
            'token'      => '6004178192:AAHxT-DZltQhl3v5v5j5Xor8yHlk-3hnzWM',
            'name'       => 'SredaInfo'

        ],

        'SredaError' => [
            'username'     => 'SredaError',
            'token'        => '6209799102:AAEKwSuzp4nkAxdri40dzAE1HzsOcK-5OK0',
            'name'         => 'SredaError'
        ],

        'SredaInfoTest' => [
            'username'   => 'SredaInfoTest',
            'token'      => '5828499043:AAG4bysuKG9FcjtCNCSNA1ASCkNYFLvFVZk',
            'name'       => 'SredaInfoTest'
        ],

        'SredaErrorTest' => [
            'username'     => 'SredaErrorTest',
            'token'        => '6016396027:AAFQcBYORV0I0zuYGZ2Wx7W_uEFWXEeG_ww',
            'name'         => 'SredaErrorTest'
        ],

    ],



    /*
     *
     *  actions for people
     *
     *
     *
     *
     */

    'actions' => [
        'people' => [
            TelegramConst::WEBHOOK_PEOPLE_ACTION_ASSIST,
            TelegramConst::WEBHOOK_PEOPLE_ACTION_PROJECTS,
            TelegramConst::WEBHOOK_PEOPLE_ACTION_PROJECT,
//            TelegramConst::WEBHOOK_PEOPLE_ACTION_SURVEYS,
            TelegramConst::WEBHOOK_PEOPLE_ACTION_SEARCH,
        ]
    ],

  /*
  |--------------------------------------------------------------------------
  | Default Bot Name
  |--------------------------------------------------------------------------
  |
  | Here you may specify which of the bots you wish to use as
  | your default bot for regular use.
  |
  */
  'default' => 'SredaInfo',

  /*
  |--------------------------------------------------------------------------
  | Asynchronous Requests [Optional]
  |--------------------------------------------------------------------------
  |
  | When set to True, All the requests would be made non-blocking (Async).
  |
  | Default: false
  | Possible Values: (Boolean) "true" OR "false"
  |
  */
  'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', FALSE),

  /*
  |--------------------------------------------------------------------------
  | HTTP Client Handler [Optional]
  |--------------------------------------------------------------------------
  |
  | If you'd like to use a custom HTTP Client Handler.
  | Should be an instance of \Telegram\Bot\HttpClients\HttpClientInterface
  |
  | Default: GuzzlePHP
  |
  */
  'http_client_handler' => NULL,

  /*
  |--------------------------------------------------------------------------
  | Resolve Injected Dependencies in commands [Optional]
  |--------------------------------------------------------------------------
  |
  | Using Laravel's IoC container, we can easily type hint dependencies in
  | our command's constructor and have them automatically resolved for us.
  |
  | Default: true
  | Possible Values: (Boolean) "true" OR "false"
  |
  */
  'resolve_command_dependencies' => TRUE,

  /*
  |--------------------------------------------------------------------------
  | Register Telegram Global Commands [Optional]
  |--------------------------------------------------------------------------
  |
  | If you'd like to use the SDK's built in command handler system,
  | You can register all the global commands here.
  |
  | Global commands will apply to all the bots in system and are always active.
  |
  | The command class should extend the \Telegram\Bot\Commands\Command class.
  |
  | Default: The SDK registers, a help command which when a user sends /help
  | will respond with a list of available commands and description.
  |
  */
//  'commands' => [
//    Telegram\Bot\Commands\HelpCommand::class,
//      \App\Socialite\Telegram\Commands\StartCommand::class,
//  ],

  /*
  |--------------------------------------------------------------------------
  | Command Groups [Optional]
  |--------------------------------------------------------------------------
  |
  | You can organize a set of commands into groups which can later,
  | be re-used across all your bots.
  |
  | You can create 4 types of groups:
  | 1. Group using full path to command classes.
  | 2. Group using shared commands: Provide the key name of the shared command
  | and the system will automatically resolve to the appropriate command.
  | 3. Group using other groups of commands: You can create a group which uses other
  | groups of commands to bundle them into one group.
  | 4. You can create a group with a combination of 1, 2 and 3 all together in one group.
  |
  | Examples shown below are by the group type for you to understand each of them.
  */
  'command_groups' => [
    /* // Group Type: 1
       'commmon' => [
            Acme\Project\Commands\TodoCommand::class,
            Acme\Project\Commands\TaskCommand::class,
       ],
    */

    /* // Group Type: 2
       'subscription' => [
            'start', // Shared Command Name.
            'stop', // Shared Command Name.
       ],
    */

    /* // Group Type: 3
        'auth' => [
            Acme\Project\Commands\LoginCommand::class,
            Acme\Project\Commands\SomeCommand::class,
        ],

        'stats' => [
            Acme\Project\Commands\UserStatsCommand::class,
            Acme\Project\Commands\SubscriberStatsCommand::class,
            Acme\Project\Commands\ReportsCommand::class,
        ],

        'admin' => [
            'auth', // Command Group Name.
            'stats' // Command Group Name.
        ],
    */

    /* // Group Type: 4
       'myBot' => [
            'admin', // Command Group Name.
            'subscription', // Command Group Name.
            'status', // Shared Command Name.
            'Acme\Project\Commands\BotCommand' // Full Path to Command Class.
       ],
    */
  ],

  /*
  |--------------------------------------------------------------------------
  | Shared Commands [Optional]
  |--------------------------------------------------------------------------
  |
  | Shared commands let you register commands that can be shared between,
  | one or more bots across the project.
  |
  | This will help you prevent from having to register same set of commands,
  | for each bot over and over again and make it easier to maintain them.
  |
  | Shared commands are not active by default, You need to use the key name to register them,
  | individually in a group of commands or in bot commands.
  | Think of this as a central storage, to register, reuse and maintain them across all bots.
  |
  */
  'shared_commands' => [
    // 'start' => Acme\Project\Commands\StartCommand::class,
    // 'stop' => Acme\Project\Commands\StopCommand::class,
    // 'status' => Acme\Project\Commands\StatusCommand::class,
  ],

  'group_ids' => [

//      'SredaInfo'       => '-1001976999819',
//
//      'SredaInfoTest'   => '-1001913142912',
//
//      'SredaError'      => '-1001988450584',
//
//      'SredaErrorTest'  => '-1001937609571',

  ],

    /*
    |
    |   COSTYL FOR  TELEGRAM
    |
    |   Keyboard Buttons
    |
    |
    |
    |
     */

    'keyboard' => [
        TelegramConst::WEBHOOK_MSG_ACT_ASSIST => [
            'AI Assistant',
            'AI Ассистент',
            'AI Помічник',
        ],
        TelegramConst::WEBHOOK_MSG_ACT_PROJECTS => [
            '<= Back',
            '<= К проектам',
            '<= До проектів',
        ]
    ]

];
