<?php

namespace weareferal\RemoteSync\console\controllers;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;
use yii\console\ExitCode;

use weareferal\RemoteSync\RemoteSync;

/**
 * Manage remote volumes
 */
class VolumeController extends Controller
{
    /**
     * List remote volumes
     */
    public function actionList()
    {
        try {
            $results = RemoteSync::getInstance()->remotesync->listVolumes();
            if (count($results) <= 0) {
                $this->stdout("No remote volumes" . PHP_EOL, Console::FG_YELLOW);
            } else {
                $this->stdout("Remote volumes:" . PHP_EOL, Console::FG_GREEN);
                foreach ($results as $result) {
                    $this->stdout(" " . $result['value'] . PHP_EOL);
                }
            }
        } catch (\Exception $e) {
            Craft::$app->getErrorHandler()->logException($e);
            $this->stderr('Error: ' . $e->getMessage() . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }

    /**
     * Push local volume to remote destination
     */
    public function actionPush()
    {
        try {
            $filename = RemoteSync::getInstance()->remotesync->pushVolumes();
            if (!$filename) {
                $this->stdout("No remote volumes" . PHP_EOL, Console::FG_YELLOW);
            } else {
                $this->stdout("Pushed local volume to remote destination:" . PHP_EOL, Console::FG_GREEN);
                $this->stdout(" " . $filename . PHP_EOL);
            }
        } catch (\Exception $e) {
            Craft::$app->getErrorHandler()->logException($e);
            $this->stderr('Error: ' . $e->getMessage() . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }

    /**
     * Pull remote volume and restore it locally
     */
    public function actionPull($filename)
    {
        try {
            RemoteSync::getInstance()->remotesync->pullVolume($filename);
            $this->stdout("Pulled and restored remote volume:" . PHP_EOL, Console::FG_GREEN);
            $this->stdout(" " . $filename . PHP_EOL);
        } catch (\Exception $e) {
            Craft::$app->getErrorHandler()->logException($e);
            $this->stderr('Error: ' . $e->getMessage() . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }

    /**
     * Delete a remote volume
     */
    public function actionDelete($filename)
    {
        try {
            RemoteSync::getInstance()->remotesync->deleteVolume($filename);
            $this->stdout("Deleted remote volume:" . PHP_EOL, Console::FG_GREEN);
            $this->stdout(" " . $filename . PHP_EOL);
        } catch (\Exception $e) {
            Craft::$app->getErrorHandler()->logException($e);
            $this->stderr('Error: ' . $e->getMessage() . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }
}
