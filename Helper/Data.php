<?php
/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_OrderSuccessPage
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

namespace MageINIC\OrderSuccessPage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Helper Data to get store configuration values
 */
class Data extends AbstractHelper
{
    /**#@+
     * Constants defined to get the value of store Config.
     */
    public const ORDER_SUCCESS_ENABLE = 'order_success_page/general/enable_disable';
    public const SHOW_SHIPPING_ADDRESS = 'order_success_page/general/show_shipping_address';
    public const SHOW_SHIPPING_METHOD = 'order_success_page/general/show_shipping_method';
    public const SHOW_BILLING_ADDRESS = 'order_success_page/general/show_billing_address';
    public const SHOW_PAYMENT_METHOD = 'order_success_page/general/show_payment_method';
    public const SHOW_ORDER_PRODUCT = 'order_success_page/general/show_order_product';
    public const SHOW_ORDER_STATUS = 'order_success_page/general/show_order_status';
    public const SHOW_PRINT_ORDER_LINK = 'order_success_page/general/show_print_order_link';
    public const SHOW_REORDER_LINK = 'order_success_page/general/show_reorder_link';
    public const DESCRIPTION = 'order_success_page/general/description';
    public const SHOW_THANK_YOU_MESSAGE = 'order_success_page/thank_config/thank_message';
    public const THANK_YOU_MESSAGE_SIZE = 'order_success_page/thank_config/size_thanks';
    public const THANK_YOU_MESSAGE_COLOR = 'order_success_page/thank_config/color_thanks';
    public const TEXT_BEFORE = 'order_success_page/before_config/text_before';
    public const TEXT_BEFORE_SIZE = 'order_success_page/before_config/size_before_text';
    public const TEXT_BEFORE_COLOR = 'order_success_page/before_config/color_text_before';
    public const TEXT_AFTER = 'order_success_page/after_config/text_after';
    public const TEXT_AFTER_SIZE = 'order_success_page/after_config/size_after_text';
    public const TEXT_AFTER_COLOR = 'order_success_page/after_config/color_text_after';
    public const ENABLE_REORDER = 'sales/reorder/allow';
    /**#@-*/

    /**
     * Module Enable Action
     *
     * @return mixed
     */
    public function isEnable(): mixed
    {
        return $this->scopeConfig->getValue(
            self::ORDER_SUCCESS_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Shipping Address
     *
     * @return bool
     */
    public function isEnableShippingAddress(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_SHIPPING_ADDRESS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Shipping Method
     *
     * @return bool
     */
    public function isEnableShippingMethod(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_SHIPPING_METHOD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable BiLLing Address
     *
     * @return bool
     */
    public function isEnableBillingAddress(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_BILLING_ADDRESS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Payment Method
     *
     * @return bool
     */
    public function isEnablePaymentMethod(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_PAYMENT_METHOD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Product Details
     *
     * @return bool
     */
    public function isEnableOrderProduct(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_ORDER_PRODUCT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Order Status
     *
     * @return bool
     */
    public function isEnableOrderStatus(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_ORDER_STATUS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Can View Print Order
     *
     * @return bool
     */
    public function isEnablePrintOrderLink(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_PRINT_ORDER_LINK,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Can View Re-Order
     *
     * @return bool
     */
    public function isEnableReOrderLink(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SHOW_REORDER_LINK,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable|Disable Re-Order
     *
     * @return bool
     */
    public function isEnableReOrder(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::ENABLE_REORDER,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Editor Details
     *
     * @return mixed
     */
    public function isEditor(): mixed
    {
        return $this->scopeConfig->getValue(
            self::DESCRIPTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Thanks Message
     *
     * @return string|null
     */
    public function getThankMessage(): ?string
    {
        return $this->scopeConfig->getValue(
            self::SHOW_THANK_YOU_MESSAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Thank Message Size
     *
     * @return string|null
     */
    public function getThankMessageSize(): ?string
    {
        return $this->scopeConfig->getValue(
            self::THANK_YOU_MESSAGE_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Thank Message Color
     *
     * @return string|null
     */
    public function getThankMessageColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::THANK_YOU_MESSAGE_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Before Order
     *
     * @return string|null
     */
    public function getBeforeText(): ?string
    {
        return $this->scopeConfig->getValue(
            self::TEXT_BEFORE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Before Size
     *
     * @return string|null
     */
    public function getBeforeTextSize(): ?string
    {
        return $this->scopeConfig->getValue(
            self::TEXT_BEFORE_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Before Color
     *
     * @return string|null
     */
    public function getBeforeTextColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::TEXT_BEFORE_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text After Order
     *
     * @return mixed
     */
    public function getAfterText(): mixed
    {
        return $this->scopeConfig->getValue(
            self::TEXT_AFTER,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text After Size
     *
     * @return string|null
     */
    public function getAfterTextSize(): ?string
    {
        return $this->scopeConfig->getValue(
            self::TEXT_AFTER_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text After Color
     *
     * @return string|null
     */
    public function getAfterTextColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::TEXT_AFTER_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }
}
