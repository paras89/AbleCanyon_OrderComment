<?php
/**
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @category    AbleCanyon
 * @package     AbleCanyon_OrderComment
 * @copyright   Copyright (c) 2014-2015 AbleCanyon
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 */
class AbleCanyon_OrderComment_Model_Observer extends Varien_Object
{
    /**
     * Save comment from order review section to order
     * Events: checkout_type_onepage_save_order | checkout_type_multishipping_create_orders_single
     * @param $observer
     */
    public function saveOrderComment($observer)
    {
        $orderComment = Mage::app()->getRequest()->getPost('ordercomment');
        if (is_array($orderComment) && isset($orderComment['comment'])) {
            $comment = trim($orderComment['comment']);
            $comment = nl2br(Mage::helper('ordercomment')->stripTags($comment));

            if (!empty($comment)) {
                $order = $observer->getEvent()->getOrder();
                $order->addStatusHistoryComment('Customer Order Comment: ' . $comment);
            }
        }
    }
}