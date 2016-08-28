<?php

/**
 * This is the model class for table "Profile".
 *
 * The followings are the available columns in table 'Profile':
 * @property string $IDProfile
 * @property string $IDAccount
 * @property string $FisrtName
 * @property string $LastName
 * @property string $DateOfBirth
 * @property string $Thumbnail
 * @property string $DisplayName
 * @property string $ProfileStatus
 * @property string $updt_date
 * @property string $updt_usrID
 *
 * The followings are the available model relations:
 * @property Account $iDProfile
 */
class Profile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDAccount, FisrtName, LastName, updt_date, updt_usrID', 'required'),
			array('IDAccount, updt_usrID', 'length', 'max'=>19),
			array('Thumbnail', 'length', 'max'=>1073741823),
			array('DateOfBirth, DisplayName, ProfileStatus', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IDProfile, IDAccount, FisrtName, LastName, DateOfBirth, Thumbnail, DisplayName, ProfileStatus, updt_date, updt_usrID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'iDProfile' => array(self::BELONGS_TO, 'Account', 'IDProfile'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IDProfile' => 'Idprofile',
			'IDAccount' => 'Idaccount',
			'FisrtName' => 'Fisrt Name',
			'LastName' => 'Last Name',
			'DateOfBirth' => 'Date Of Birth',
			'Thumbnail' => 'Thumbnail',
			'DisplayName' => 'Display Name',
			'ProfileStatus' => 'Profile Status',
			'updt_date' => 'Updt Date',
			'updt_usrID' => 'Updt Usr',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('IDProfile',$this->IDProfile,true);
		$criteria->compare('IDAccount',$this->IDAccount,true);
		$criteria->compare('FisrtName',$this->FisrtName,true);
		$criteria->compare('LastName',$this->LastName,true);
		$criteria->compare('DateOfBirth',$this->DateOfBirth,true);
		$criteria->compare('Thumbnail',$this->Thumbnail,true);
		$criteria->compare('DisplayName',$this->DisplayName,true);
		$criteria->compare('ProfileStatus',$this->ProfileStatus,true);
		$criteria->compare('updt_date',$this->updt_date,true);
		$criteria->compare('updt_usrID',$this->updt_usrID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
