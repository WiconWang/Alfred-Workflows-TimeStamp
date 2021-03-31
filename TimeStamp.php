<?php
ini_set('date.timezone', 'Asia/Shanghai');
require_once('workflows.php');

class TimeStamp
{
    private function isDateTime($dateTime)
    {
        $ret = strtotime($dateTime);
        return $ret !== FALSE && $ret != -1;
    }


    private function getDifference($queryStamp, $nowStamp)
    {
        $cle = $queryStamp - $nowStamp;
        if ($cle > 0) {
            $d = floor($cle / 3600 / 24);
            $h = floor(($cle % (3600 * 24)) / 3600);
            $m = floor(($cle % (3600 * 24)) % 3600 / 60);
            $s = floor(($cle % (3600 * 24)) % 60);
        } elseif ($cle < 0) {
            $d = ceil($cle / 3600 / 24);
            $h = ceil(($cle % (3600 * 24)) / 3600);
            $m = ceil(($cle % (3600 * 24)) % 3600 / 60);
            $s = ceil(($cle % (3600 * 24)) % 60);
        } else {
            $d = 0;
            $h = 0;
            $m = 0;
            $s = 0;
        }
        return "当前时间差 $d 天 $h 小时 $m 分 $s 秒";

    }

    public function getTimeStamp($query)
    {
        $workflows = new Workflows();
        $now = time();
        $query = trim($query);

        if ($query == 'now') {
            $workflows->result($query,
                date('Y年m月d日 H时i分s秒', time()),
                "系统时间：" . date('Y年m月d日 H时i分s秒', time()),
                '',
                'icon.png', false);

            $workflows->result($query,
                date('Y-m-d H:i:s', time()),
                "系统时间：" . date('Y-m-d H:i:s', time()),
                '',
                'icon.png', false);

            $workflows->result($query,
                date('YmdHis', time()),
                "系统时间：" . date('YmdHis', time()),
                '',
                'icon.png', false);

            $workflows->result($query,
                time() * 1000,
                "毫秒时间戳：" . time() * 1000,
                '',
                'icon.png', false);

            $workflows->result($query,
                time(),
                "系统时间戳：" . time(),
                '',
                'icon.png', false);

            echo $workflows->toxml();
        }
        if (is_numeric($query)) {
            $cle = $query - $now;
            if (preg_match('/^\d{1,10}$/', $query)) {
                $workflows->result($query,
                    date('Y-m-d H:i:s', $query),
                    '目标时间：' . date('Y-m-d H:i:s', $query),
                    $this->getDifference($query, time()),
                    'icon.png', false);
                echo $workflows->toxml();
            }

            if (preg_match('/^\d{11,13}$/', $query)) {
                $resQuery = $query / 1000;
                $workflows->result($resQuery,
                    date('Y-m-d H:i:s', $resQuery),
                    '目标时间：' . date('Y-m-d H:i:s', $resQuery),
                    $this->getDifference($resQuery, time()),
                    'icon.png', false);
                echo $workflows->toxml();
            }
        }
        if ($this->isDateTime($query)) {
            $workflows->result($query,
                strtotime($query),
                '目标时间戳：' . strtotime($query),
                '与当前时间戳差：' . (strtotime($query) - $now) . '秒',
                'icon.png', false);
            $workflows->result($query,
                strtotime($query) * 1000,
                '目标时间毫秒戳：' . strtotime($query) * 1000,
                '与当前时间毫秒戳差：' . ((strtotime($query) - $now) * 1000) . '毫秒',
                'icon.png', false);
            echo $workflows->toxml();
        }
        exit;

    }

}
