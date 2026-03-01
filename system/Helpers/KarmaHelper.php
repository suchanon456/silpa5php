<?php
/**
 * KarmaHelper - ช่วยติดตามกรรม
 * 
 * ฟังก์ชันช่วยเหลือสำหรับติดตามการกระทำและผลกรรม
 */

namespace System\Helpers;

class KarmaHelper
{
    /**
     * บันทึกกรรม
     */
    protected static $karma = [];

    /**
     * บันทึกการกระทำ
     */
    public static function recordAction($actor, $action, $target, $result)
    {
        $karma = [
            'actor' => $actor,
            'action' => $action,
            'target' => $target,
            'result' => $result,
            'timestamp' => time(),
            'consequence' => self::calculateConsequence($action, $result)
        ];

        self::$karma[] = $karma;
        return $karma;
    }

    /**
     * คำนวณผลกรรม
     */
    public static function calculateConsequence($action, $result)
    {
        if ($result === true) {
            $goodActions = ['help', 'create', 'improve', 'save', 'support'];
            
            foreach ($goodActions as $good) {
                if (strpos(strtolower($action), strtolower($good)) !== false) {
                    return 'positive';
                }
            }
        }

        $badActions = ['delete', 'destroy', 'harm', 'break', 'steal'];
        
        foreach ($badActions as $bad) {
            if (strpos(strtolower($action), strtolower($bad)) !== false) {
                return 'negative';
            }
        }

        return 'neutral';
    }

    /**
     * ดึงกรรมทั้งหมด
     */
    public static function getKarma()
    {
        return self::$karma;
    }

    /**
     * ดึงกรรมของผู้ใช้
     */
    public static function getActorKarma($actor)
    {
        return array_filter(self::$karma, function($k) use ($actor) {
            return $k['actor'] === $actor;
        });
    }

    /**
     * คำนวณคะแนนกรรม
     */
    public static function calculateKarmaScore($actor)
    {
        $actorKarma = self::getActorKarma($actor);
        $score = 0;

        foreach ($actorKarma as $karma) {
            if ($karma['consequence'] === 'positive') {
                $score += 1;
            } elseif ($karma['consequence'] === 'negative') {
                $score -= 1;
            }
        }

        return $score;
    }

    /**
     * ลบกรรม (ยกเลิก)
     */
    public static function undoAction($index)
    {
        if (isset(self::$karma[$index])) {
            unset(self::$karma[$index]);
            return true;
        }

        return false;
    }

    /**
     * ล้างกรรมทั้งหมด
     */
    public static function clearKarma()
    {
        self::$karma = [];
        return true;
    }

    /**
     * ดึงสถิติกรรม
     */
    public static function getKarmaStats()
    {
        $positive = 0;
        $negative = 0;
        $neutral = 0;

        foreach (self::$karma as $karma) {
            if ($karma['consequence'] === 'positive') {
                $positive++;
            } elseif ($karma['consequence'] === 'negative') {
                $negative++;
            } else {
                $neutral++;
            }
        }

        return [
            'total' => count(self::$karma),
            'positive' => $positive,
            'negative' => $negative,
            'neutral' => $neutral,
            'score' => $positive - $negative
        ];
    }
}
