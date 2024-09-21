<?php
namespace app\controllers;

use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\rest\Controller;
use app\models\LoanApplication;

class LoanController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionProcessor($delay = 5): array
    {
        $emptyLoan = true;
        while ($emptyLoan) {
            // Попытаемся найти одну заявку со статусом "pending" и заблокировать ее для других процессов
            $loan = LoanApplication::findPendingLoanForUpdate();

            // Если больше нет заявок для обработки, завершаем цикл
            if (!$loan) {
                $emptyLoan = false;
                continue;
            }

            // Эмулируем задержку принятия решения
            sleep($delay);

            // Принятие решения с вероятностью 10% на одобрение
            $isApproved = (rand(1, 100) <= 10); // 10% вероятность

            // Убедимся, что у пользователя нет уже одобренной заявки
            $existingApprovedLoan = LoanApplication::find()
                ->where(['user_id' => $loan->user_id, 'status' => LoanApplication::STATUS_APPROVED])
                ->exists();

            if (!$existingApprovedLoan && $isApproved) {
                $loan->status = LoanApplication::STATUS_APPROVED;
            } else {
                $loan->status = LoanApplication::STATUS_DECLINED;
            }
            $loan->save();
        }
        \Yii::$app->response->statusCode = 200;
        return [
            'result' => true
        ];
    }

    /**
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionCreate(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $loan = \Yii::$app->request->post();
        // Проверяем наличие всех обязательных полей
        if (!isset($loan['user_id'], $loan['amount'], $loan['term'])) {
            throw new BadRequestHttpException('Missing required fields.');
        }

        // Проверка на наличие одобренной заявки у пользователя
        $approvedRequest = LoanApplication::find()
            ->where(['user_id' => $loan['user_id'], 'status' => LoanApplication::STATUS_APPROVED])
            ->exists();

        if ($approvedRequest) {
            return [
                'result' => false,
                'message' => 'User already has an approved loan request.'
            ];
        }

        // Создание новой заявки
        $loanRequest = new LoanApplication();
        $loanRequest->user_id = $loan['user_id'];
        $loanRequest->amount = $loan['amount'];
        $loanRequest->term = $loan['term'];
        $loanRequest->status = LoanApplication::STATUS_PENDING;
        if ($loanRequest->save()) {
            \Yii::$app->response->statusCode = 200;
            return [
                'result' => true,
                'id' => $loanRequest->id,
            ];
        }
        \Yii::$app->response->statusCode = 400;
        return [
            'result' => false
        ];
    }
}
