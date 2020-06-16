<?php

namespace weareferal\remotesync\queue;

use craft\queue\BaseJob;

use weareferal\remotesync\RemoteSync;

class PushDatabaseJob extends BaseJob
{
    public function execute($queue)
    {
        RemoteSync::getInstance()->remotesync->pushDatabase();
    }

    protected function defaultDescription()
    {
        return 'Push database';
    }
}
