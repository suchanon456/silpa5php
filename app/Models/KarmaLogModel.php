<?php

namespace App\Models;

/**
 * KarmaLogModel - บันทึกกรรม
 * 
 * ติดตามการกระทำของผู้ใช้และผลกรรมของการกระทำนั้น
 * - ศีลมุสาวาท (Musavada): บันทึกอย่างจริงใจ
 * - ศีลสติ (Sati): มีสติในการบันทึก
 */
class KarmaLogModel extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'karma_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
        'points',
        'description',
        'reference_type',
        'reference_id',
        'status'
    ];

    /**
     * Karma action constants
     */
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';
    const HELP_OTHERS = 'help_others';
    const VIOLATE_PRECEPT = 'violate_precept';

    /**
     * Default points for actions
     */
    const DEFAULT_POINTS = [
        self::CREATE => 10,
        self::READ => 1,
        self::UPDATE => 5,
        self::DELETE => -20,
        self::HELP_OTHERS => 50,
        self::VIOLATE_PRECEPT => -100
    ];

    /**
     * Log user action (Musavada - truthfully record)
     * บันทึกการกระทำของผู้ใช้
     *
     * @param int $userId
     * @param string $action
     * @param int $points
     * @param string $description
     * @param string $referenceType
     * @param int $referenceId
     * @return int|false
     */
    public function logAction($userId, $action, $points = 0, $description = '', $referenceType = '', $referenceId = 0)
    {
        // Use default points if not provided
        if ($points === 0 && isset(self::DEFAULT_POINTS[$action])) {
            $points = self::DEFAULT_POINTS[$action];
        }

        return $this->insert([
            'user_id' => $userId,
            'action' => $action,
            'points' => $points,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'status' => 'recorded'
        ]);
    }

    /**
     * Get karma score for user
     * ได้คะแนนกรรมของผู้ใช้
     *
     * @param int $userId
     * @return int
     */
    public function getUserKarmaScore($userId)
    {
        $result = $this->where('user_id', $userId)
            ->selectSum('points')
            ->first();

        return $result->points ?? 0;
    }

    /**
     * Get karma log for user
     * ได้บันทึกกรรมของผู้ใช้
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getUserKarmaLog($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get top karma actions
     * ได้การกระทำที่มี karma สูงสุด
     *
     * @param int $limit
     * @return array
     */
    public function getTopKarmaActions($limit = 10)
    {
        return $this->selectSum('points', 'total_points')
            ->groupBy('action')
            ->orderBy('total_points', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get negative karma logs (violations)
     * ได้บันทึก karma ที่เป็นลบ (การละเมิด)
     *
     * @param int $limit
     * @return array
     */
    public function getViolations($limit = 50)
    {
        return $this->where('points <', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get positive karma logs (blessings)
     * ได้บันทึก karma ที่เป็นบวก (ความเป็นสิริมงคล)
     *
     * @param int $limit
     * @return array
     */
    public function getBlessings($limit = 50)
    {
        return $this->where('points >', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get karma average
     * ได้ค่าเฉลี่ยกรรม
     *
     * @return float
     */
    public function getAverageKarma()
    {
        $result = $this->selectAvg('points', 'average')
            ->first();

        return $result->average ?? 0.0;
    }

    /**
     * Get daily karma summary
     * ได้สรุปกรรมรายวัน
     *
     * @param string $date (Y-m-d format)
     * @return array
     */
    public function getDailySummary($date)
    {
        return $this->where('DATE(created_at)', $date)
            ->selectSum('points', 'total_points')
            ->groupBy('user_id')
            ->findAll();
    }

    /**
     * Get karma trend
     * ได้แนวโน้มกรรม (last 7 days)
     *
     * @param int $userId
     * @return array
     */
    public function getKarmaTrend($userId)
    {
        return $this->where('user_id', $userId)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->selectSum('points', 'total_points')
            ->groupBy('DATE(created_at)')
            ->orderBy('DATE(created_at)', 'ASC')
            ->findAll();
    }
}
