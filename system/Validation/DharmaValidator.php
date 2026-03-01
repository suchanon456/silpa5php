<?php
/**
 * DharmaValidator - Validator มีธรรมะ
 * 
 * ตรวจสอบข้อมูลด้วยจิตสำนึกธรรมะ
 */

namespace System\Validation;

class DharmaValidator
{
    /**
     * ข้อมูลที่ต้องตรวจสอบ
     */
    protected $data = [];

    /**
     * กฎการตรวจสอบ
     */
    protected $rules = [];

    /**
     * ข้อความแสดงข้อผิดพลาด
     */
    protected $errors = [];

    /**
     * Constructor
     */
    public function __construct($data = [], $rules = [])
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * ตั้งค่าข้อมูล
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * ตั้งค่ากฎ
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * ดำเนินการตรวจสอบ
     */
    public function validate()
    {
        $this->errors = [];

        foreach ($this->rules as $field => $rule) {
            $value = $this->data[$field] ?? null;
            $this->validateField($field, $value, $rule);
        }

        return empty($this->errors);
    }

    /**
     * ตรวจสอบฟิลด์เดียว
     */
    protected function validateField($field, $value, $rules)
    {
        $ruleArray = explode('|', $rules);

        foreach ($ruleArray as $rule) {
            $this->applyRule($field, $value, trim($rule));
        }
    }

    /**
     * ใช้กฎการตรวจสอบ
     */
    protected function applyRule($field, $value, $rule)
    {
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];

        switch ($ruleName) {
            case 'required':
                $this->validateRequired($field, $value);
                break;
            case 'email':
                $this->validateEmail($field, $value);
                break;
            case 'min':
                $this->validateMin($field, $value, $ruleParts[1] ?? null);
                break;
            case 'max':
                $this->validateMax($field, $value, $ruleParts[1] ?? null);
                break;
            case 'numeric':
                $this->validateNumeric($field, $value);
                break;
            case 'truth':
                $this->validateTruth($field, $value);
                break;
            case 'compassion':
                $this->validateCompassion($field, $value);
                break;
        }
    }

    /**
     * ตรวจสอบว่าจำเป็น
     */
    protected function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->addError($field, "{$field} ต้องกรอก");
        }
    }

    /**
     * ตรวจสอบ email
     */
    protected function validateEmail($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "{$field} ต้องเป็น email ที่ถูกต้อง");
        }
    }

    /**
     * ตรวจสอบความยาวต่ำสุด
     */
    protected function validateMin($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->addError($field, "{$field} ต้องมีความยาวอย่างน้อย {$min} ตัวอักษร");
        }
    }

    /**
     * ตรวจสอบความยาวสูงสุด
     */
    protected function validateMax($field, $value, $max)
    {
        if (strlen($value) > $max) {
            $this->addError($field, "{$field} ต้องมีความยาวไม่เกิน {$max} ตัวอักษร");
        }
    }

    /**
     * ตรวจสอบตัวเลข
     */
    protected function validateNumeric($field, $value)
    {
        if (!is_numeric($value)) {
            $this->addError($field, "{$field} ต้องเป็นตัวเลข");
        }
    }

    /**
     * ตรวจสอบความเป็นจริง
     */
    protected function validateTruth($field, $value)
    {
        // TODO: ตรวจสอบความเป็นจริงของข้อมูล
        if (empty($value)) {
            $this->addError($field, "{$field} ต้องเป็นความจริง");
        }
    }

    /**
     * ตรวจสอบความเมตตา
     */
    protected function validateCompassion($field, $value)
    {
        // TODO: ตรวจสอบความเมตตาของข้อมูล
        if (empty($value)) {
            $this->addError($field, "{$field} ต้องเป็นเมตตา");
        }
    }

    /**
     * เพิ่มข้อผิดพลาด
     */
    protected function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    }

    /**
     * ดึงข้อผิดพลาด
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * ตรวจสอบว่ามีข้อผิดพลาด
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * ดึงข้อผิดพลาดแรก
     */
    public function getFirstError()
    {
        if (empty($this->errors)) {
            return null;
        }

        $firstField = reset($this->errors);
        return $firstField[0] ?? null;
    }
}
