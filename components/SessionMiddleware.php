<?php

namespace app\components;

use Yii;
use DateTime;
use yii\base\Component;

class SessionMiddleware extends Component
{
    public function checkSession()
    {
        $app = Yii::$app;
        $user = $app->user;

        // Cek jika user belum login
        if ($user->isGuest) {
            return;
        }

        // Ambil model pengguna dari database
        $identity = $user->identity;

        // Pastikan identity ada dan memiliki session_end_time
        if ($identity && isset($identity['batasWaktu'])) {
            $batasWaktu = new DateTime($identity['batasWaktu']);
            $batasWaktu = strtotime($batasWaktu->format('Y-m-d H:i:s'));
            $timeNow = strtotime(date('Y-m-d H:i:s'));

            if ($timeNow > $batasWaktu) {
                Yii::$app->user->logout(true);
                $app->response->redirect(['/'])->send(); // Redirect ke controller 'site' dan action 'login'
                $app->end();
            }
        }
    }
}
