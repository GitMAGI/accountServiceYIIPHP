<?php

/**
 * This is the model class for table "Account".
 *
 * The followings are the available columns in table 'Account':
 * @property string $IDAccount
 * @property string $UserName
 * @property string $DigestPwd
 * @property boolean $PwdExpires
 * @property string $PwdUpdateDate
 * @property integer $PwdLifeTime
 * @property boolean $AccountExpires
 * @property string $AccountCreationDate
 * @property integer $AccountLifeTime
 * @property string $EmailMain
 * @property string $PhoneNumber
 * @property string $EmailRecovery
 * @property string $RecoveryType
 * @property integer $UAC
 * @property integer $PwdFailuresCount
 * @property integer $PwdMaxFailuresCount
 * @property string $LastLoginDateTime
 * @property string $LastLogoffDateTime
 * @property string $LastLoginIP
 * @property string $LastLoginMAC
 * @property string $updt_date
 * @property string $updt_usrID
 *
 * The followings are the available model relations:
 * @property Profile $profile
 */
class Account extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UserName, DigestPwd, AccountCreationDate, EmailMain, UAC, updt_date, updt_usrID', 'required'),
			array('PwdLifeTime, AccountLifeTime, UAC, PwdFailuresCount, PwdMaxFailuresCount', 'numerical', 'integerOnly'=>true),
			array('DigestPwd', 'length', 'max'=>60),
			array('LastLoginIP', 'length', 'max'=>15),
			array('LastLoginMAC', 'length', 'max'=>17),
			array('updt_usrID', 'length', 'max'=>19),
			array('PwdExpires, PwdUpdateDate, AccountExpires, PhoneNumber, EmailRecovery, RecoveryType, LastLoginDateTime, LastLogoffDateTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IDAccount, UserName, DigestPwd, PwdExpires, PwdUpdateDate, PwdLifeTime, AccountExpires, AccountCreationDate, AccountLifeTime, EmailMain, PhoneNumber, EmailRecovery, RecoveryType, UAC, PwdFailuresCount, PwdMaxFailuresCount, LastLoginDateTime, LastLogoffDateTime, LastLoginIP, LastLoginMAC, updt_date, updt_usrID', 'safe', 'on'=>'search'),
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
			'profile' => array(self::HAS_ONE, 'Profile', 'IDProfile'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IDAccount' => 'Idaccount',
			'UserName' => 'User Name',
			'DigestPwd' => 'Digest Pwd',
			'PwdExpires' => 'Pwd Expires',
			'PwdUpdateDate' => 'Pwd Update Date',
			'PwdLifeTime' => 'Pwd Life Time',
			'AccountExpires' => 'Account Expires',
			'AccountCreationDate' => 'Account Creation Date',
			'AccountLifeTime' => 'Account Life Time',
			'EmailMain' => 'Email Main',
			'PhoneNumber' => 'Phone Number',
			'EmailRecovery' => 'Email Recovery',
			'RecoveryType' => 'Recovery Type',
			'UAC' => 'User Account Control',
			'PwdFailuresCount' => 'Pwd Failures Count',
			'PwdMaxFailuresCount' => 'Pwd Max Failures Count',
			'LastLoginDateTime' => 'Last Login Date Time',
			'LastLogoffDateTime' => 'Last Logoff Date Time',
			'LastLoginIP' => 'Last Login Ip',
			'LastLoginMAC' => 'Last Login Mac',
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

		$criteria->compare('IDAccount',$this->IDAccount,true);
		$criteria->compare('UserName',$this->UserName,true);
		$criteria->compare('DigestPwd',$this->DigestPwd,true);
		$criteria->compare('PwdExpires',$this->PwdExpires);
		$criteria->compare('PwdUpdateDate',$this->PwdUpdateDate,true);
		$criteria->compare('PwdLifeTime',$this->PwdLifeTime);
		$criteria->compare('AccountExpires',$this->AccountExpires);
		$criteria->compare('AccountCreationDate',$this->AccountCreationDate,true);
		$criteria->compare('AccountLifeTime',$this->AccountLifeTime);
		$criteria->compare('EmailMain',$this->EmailMain,true);
		$criteria->compare('PhoneNumber',$this->PhoneNumber,true);
		$criteria->compare('EmailRecovery',$this->EmailRecovery,true);
		$criteria->compare('RecoveryType',$this->RecoveryType,true);
		$criteria->compare('UAC',$this->UAC);
		$criteria->compare('PwdFailuresCount',$this->PwdFailuresCount);
		$criteria->compare('PwdMaxFailuresCount',$this->PwdMaxFailuresCount);
		$criteria->compare('LastLoginDateTime',$this->LastLoginDateTime,true);
		$criteria->compare('LastLogoffDateTime',$this->LastLogoffDateTime,true);
		$criteria->compare('LastLoginIP',$this->LastLoginIP,true);
		$criteria->compare('LastLoginMAC',$this->LastLoginMAC,true);
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
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
