<?php
namespace App\Newsletter;

/*
 * This is the interface for newsletter system
 * 
 * @Author Joel Lusavuvu <joellusavuvu39@gmail.com>
 */
interface NewsletterSubscriberInterface
{
	public function getName();

	public function getMail();
}