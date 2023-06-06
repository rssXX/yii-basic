<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\OrderInProduct;
use app\models\Product;
use app\models\Status;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index'],
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cart::find()->where(['user_id' => Yii::$app->user->id]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_product)
    {
        $product = Product::find()
            ->where(["id" => $id_product])
            ->andWhere([">", "count", 0])
            ->one();

        if (!$product)
        {
            return "Такого товара не существует.";
        }

        $ItemInCart = Cart::find()
            ->where(["product_id" => $id_product])
            ->andWhere(["user_id" => Yii::$app->user->id])
            ->one();

        if (!$ItemInCart)
        {
            $ItemInCart = new Cart([
                'product_id' => $id_product,
                'user_id' => Yii::$app->user->id,
                'count' => 1,
            ]);

            $ItemInCart->save();
            return "Товар был доавлен в корзину.";
        }

        if ($ItemInCart->count >= $product->count){
            return "товар не может быть добавлен. Нет нужного количества";
        }

        $ItemInCart->count++;
        $ItemInCart->save();

        return "Товар добавлен в корзину. Количество товара в корзине $ItemInCart->count";
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_product)
    {
        $product = Product::find()
            ->where(["id" => $id_product])
            ->andWhere([">", "count", 0])
            ->one();

        if (!$product)
        {
            return "Такого товара не существует.";
        }

        $ItemInCart = Cart::find()
            ->where(["product_id" => $id_product])
            ->andWhere(["user_id" => Yii::$app->user->id])
            ->one();

        if ($ItemInCart->count == 1){
            $ItemInCart->delete();
            return "товар удалён из корзины.";
        }

        $ItemInCart->count--;
        $ItemInCart->save();

        return "Товар убран из корзины. Количество товара в корзине $ItemInCart->count";
    }

    public function actionByOrder($password)
    {

        if (!Yii::$app->user->identity->validatePassword($password))
        {
            return "Пароль не верный";
        }

        $itemsInCart = Yii::$app->user->identity->carts;

        if (!$itemsInCart){
            return "Корзина пуста.";
        }

        $order = new Order([
            "user_id" => Yii::$app->user->identity->id,
            "status_id" => Status::find()->where(['code' =>'new'])->one()->id,
        ]);

//        return "$order->user_id";

        $order->save(false);

//        return "$order->user_id";

        foreach ($itemsInCart as $item){
            $OrderInProduct = new OrderInProduct([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "count" => $item->count,
                "cost" => $item->count * $item->product->cost,
            ]);
            $OrderInProduct->save();
            $item->delete();
        }

        return "Заказ успешно создан";
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
