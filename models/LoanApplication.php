<?php
namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property integer $amount
 * @property integer $term
 * @property integer $status
 */
class LoanApplication extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    public static function tableName(): string
    {
        return 'loan_application';
    }

    public function rules(): array
    {
        return [
            [['user_id','integer','status', 'amount'], 'integer'],
            [['amount', 'user_id', 'term'], 'required'],
            ['status', 'in', 'range' => [0, 1, 2]],
        ];
    }

    public static function findPendingLoanForUpdate(): array|ActiveRecord|null
    {
        // Строим SQL-запрос с использованием FOR UPDATE
        $sql = 'SELECT * FROM loan_application WHERE status = :status ORDER BY id LIMIT 1 FOR UPDATE';

        // Выполняем запрос с параметром и возвращаем объект модели
        return LoanApplication::findBySql($sql, [':status' => self::STATUS_PENDING])->one();
    }

}
