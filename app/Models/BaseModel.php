<?php

namespace App\Models;

use System\Core\DharmaLayers\AnattaModel;

/**
 * BaseModel - Model พื้นฐาน
 * 
 * สืบทอดจาก AnattaModel ซึ่งไม่ยึดมั่นในตัวตน
 * - Soft delete: ไม่ทำลายข้อมูล (Ahimsa)
 * - Timestamps: ติดตามการเปลี่ยนแปลง
 * - Version control: บันทึกประวัติ
 * - Impermanence: ยอมรับการเปลี่ยนแปลง
 */
class BaseModel extends AnattaModel
{
    /**
     * @var string - Table name
     */
    protected $table = 'base_table';

    /**
     * @var array - Fillable attributes
     */
    protected $fillable = [];

    /**
     * @var array - Hidden attributes
     */
    protected $hidden = ['password'];

    /**
     * @var bool - Use timestamps
     */
    protected $useTimestamps = true;

    /**
     * @var string - Created at column
     */
    protected $createdField = 'created_at';

    /**
     * @var string - Updated at column
     */
    protected $updatedField = 'updated_at';

    /**
     * @var bool - Use soft delete (Ahimsa - don't destroy)
     */
    protected $useSoftDelete = true;

    /**
     * @var string - Deleted at column
     */
    protected $deletedField = 'deleted_at';

    /**
     * Before insert hook
     * ก่อนการเพิ่มข้อมูล
     *
     * @param array $data
     * @return array
     */
    protected function beforeInsert(array $data)
    {
        // Validate with precepts before insert
        // ตรวจสอบศีลก่อนการเพิ่มข้อมูล
        
        return $data;
    }

    /**
     * Before update hook
     * ก่อนการอัปเดตข้อมูล
     *
     * @param array $data
     * @return array
     */
    protected function beforeUpdate(array $data)
    {
        // Validate with precepts before update
        // ตรวจสอบศีลก่อนการอัปเดต
        
        return $data;
    }

    /**
     * Before delete hook
     * ก่อนการลบข้อมูล (soft delete only - Ahimsa)
     *
     * @param array $data
     * @return array
     */
    protected function beforeDelete(array $data)
    {
        // Soft delete respects Ahimsa - we don't destroy
        // การลบแบบ soft respects Ahimsa - เราไม่ทำลาย
        
        return $data;
    }

    /**
     * Get with karma
     * ได้ข้อมูลพร้อมกรรม
     *
     * @param int $id
     * @return object|null
     */
    public function getWithKarma($id)
    {
        // TODO: Join with karma_logs table
        return $this->find($id);
    }

    /**
     * Log action
     * บันทึกการกระทำ (for Musavada - truthfulness)
     *
     * @param string $action
     * @param mixed $actor
     * @param string $target
     * @return bool
     */
    public function logAction($action, $actor, $target)
    {
        // TODO: Insert into action_logs table
        return true;
    }

    /**
     * Check ownership (for Adinnadana)
     * ตรวจสอบความเป็นเจ้าของ
     *
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function checkOwnership($id, $userId)
    {
        $record = $this->find($id);
        
        if (!$record) {
            return false;
        }

        return isset($record->user_id) && $record->user_id === $userId;
    }

    /**
     * Restore soft deleted record
     * คืนความชีวิตข้อมูลที่ถูกลบแบบ soft (respects Ahimsa)
     *
     * @param int $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->builder()
            ->where('id', $id)
            ->update(['deleted_at' => null]);
    }
}
