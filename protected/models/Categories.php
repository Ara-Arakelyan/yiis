<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property integer $id
 * @property string $name
 * @property string $categorie
 */
class Categories extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, categorie', 'required'),
            array('name, categorie', 'length', 'max' => 250),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, categorie', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'categorie' => 'Categorie',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($file_name) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $var = $criteria->compare('name', $file_name, true);
        $criteria->compare('categorie', $this->categorie, true);
        if (isset($var)) {
            
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Categories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function sel() {
        $list = Yii::app()->db->createCommand('select * from categories  ORDER BY  id DESC')->queryAll();

        $rss = array();
        foreach ($list as $item) {
            //process each item here
            $rss[] = $item;
        }
        $json = json_encode($rss);
        return $json;
    }

    public function inserts($file_name) {
        if (isset($file_name) && $file_name != NULL) {

            $list = Yii::app()->db->createCommand("select * from categories WHERE name =  '" . $file_name . "'")->queryAll();

            $rs = array();
            foreach ($list as $item => $value) {
                //process each item here
                $rs[] = $value;
                foreach ($value as $val) {
                    if ($val == $file_name){
                        return 1;
                    }
                };
            };
            $sql = "insert into categories (name) values (:some_value)";

            $parameters = array(":some_value" => $file_name);

            Yii::app()->db->createCommand($sql)->execute($parameters);
           
            
        }
    }

}
