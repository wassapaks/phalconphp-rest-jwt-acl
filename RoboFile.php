<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{

    function setup($env, $type=''){

        if(is_file("app/config/config.php")){
            $this->say("File Exist, Deleting Existing Config");
            $this->taskExec('rm app/config/config.php')->run();
        }

        $this->taskFileSystemStack()->copy('dist/config/config-'.$env.'.php','app/config/config.php')->run();

        if(!is_dir('sqlbackups')){
            $this->taskExec('mkdir sqlbackups')->run();
        }

        if(!is_file('.gitignore')){
            $this->taskExec('touch .gitignore')->run();
        }

        $this->taskComposerInstall()->run();

        $this->taskWriteToFile('.gitignore')
            ->line('vendor/')
            ->line('sqlbackups/')
            ->line('app/config/config.php')
            ->run();

        $this->sqlexec($type);

    }

    function sqlexec($type){
        $config = require 'app/config/config.php';
        $this->taskExec('bash migratesql.sh '.$config['database']['username'].' '.$config['database']['password'].' '.$type.' '.$config['database']['name'] )->run();
    }

    function sqldump(){
        $config = require 'app/config/config.php';
        $this->taskExec('mysqldump -u'.$config['database']['username'].' -p'.$config['database']['password'].' '.$config['database']['name'].' > sqlbackups/'.$config['database']['name'].date('Ymdhiss').'BACKUP.sql')->run();
    }

}
