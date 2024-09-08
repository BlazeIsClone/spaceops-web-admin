<?php

namespace App\Messages;

class MediaMessage
{
	/**
	 * Media restore failture message.
	 */
	public function restoreFailed(): string
	{
		return 'Temporary file cannot be restored.';
	}

	/**
	 * Media revert failture message.
	 */
	public function revertFailed(): string
	{
		return 'Temporary file cannot be reverted.';
	}
}
