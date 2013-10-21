<?php

/**
 * Session accessor.
 */
class mfwSession
{
	protected $prefix;

	protected static function singleton()
	{
		static $singleton = null;
		if(is_null($singleton)){
			$singleton = new static();
		}
		return $singleton;
	}

	protected function __construct()
	{
		$this->prefix = mfwServerEnv::cachePrefix();
		session_name("{$this->prefix}seskey");
		session_start();
	}

	/**
	 * 明示的にsession開始.
	 * session_nameを設定, session_start.
	 */
	public static function init()
	{
		self::singleton();
	}

	/**
	 * セッションに値を保存
	 */
	public static function set($key,$value)
	{
		$prefix = static::singleton()->prefix;
		$_SESSION[$prefix][$key] = $value;
		return true;
	}

	/**
	 * セッションに値が保存されているか
	 */
	public static function hasKey($key)
	{
		$prefix = static::singleton()->prefix;
		return isset($_SESSION[$prefix][$key]);
	}

	/**
	 * セッションから値を取得
	 */
	public static function get($key,$default=null)
	{
		$prefix = static::singleton()->prefix;
		return static::hasKey($key) ? $_SESSION[$prefix][$key] : $default;
	}

	/**
	 * セッションから値を削除
	 */
	public static function clear($key)
	{
		$prefix = static::singleton()->prefix;
		unset($_SESSION[$prefix][$key]);
		return true;
	}

	/**
	 * セッション全削除
	 */
	public static function clearAll()
	{
		$prefix = static::singleton()->prefix;
		unset($_SESSION[$prefix]);
		return true;
	}

}


