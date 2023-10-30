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

namespace MageINIC\OrderSuccessPage\Block;

use DateTimeInterface;
use Exception;
use IntlDateFormatter;
use Magento\Cms\Model\Template\FilterProvider;
use \Magento\Framework\Pricing\Helper\Data as Price;
use Magento\Checkout\Model\Session;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Block\Order\Totals;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\OrderFactory;
use MageINIC\OrderSuccessPage\Helper\Data;

/**
 * class Success to get helper data and order related data
 */
class Success extends Totals
{
    /**
     * @var Session
     */
    protected Session $checkoutSession;

    /**
     * @var CustomerSession
     */
    protected CustomerSession $customerSession;

    /**
     * @var OrderFactory
     */
    protected OrderFactory $_orderFactory;

    /**
     * @var Renderer
     */
    protected Renderer $render;

    /**
     * @var Price
     */
    protected Price $formatPrice;

    /**
     * @var Data
     */
    protected Data $dataHelper;

    /**
     * @var FilterProvider
     */
    private FilterProvider $filterProvider;

    /**
     * @param Session $checkoutSession
     * @param CustomerSession $customerSession
     * @param OrderFactory $orderFactory
     * @param Context $context
     * @param Registry $registry
     * @param Renderer $render
     * @param Price $formatPrice
     * @param Data $dataHelper
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Session         $checkoutSession,
        CustomerSession $customerSession,
        OrderFactory    $orderFactory,
        Context         $context,
        Registry        $registry,
        Renderer        $render,
        Price           $formatPrice,
        Data            $dataHelper,
        FilterProvider  $filterProvider,
        array           $data = []
    ) {
        parent::__construct($context, $registry, $data);
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->_orderFactory = $orderFactory;
        $this->render = $render;
        $this->formatPrice = $formatPrice;
        $this->helper = $dataHelper;
        $this->filterProvider = $filterProvider;
    }

    /**
     * Get Order
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return  $this->_order = $this->_orderFactory->create()->loadByIncrementId(
            $this->checkoutSession->getLastRealOrderId()
        );
    }

    /**
     * Get Customer Id
     *
     * @return mixed
     */
    public function getCustomerId(): mixed
    {
        return $this->customerSession->getCustomer()->getId();
    }

    /**
     * Get Enable|Disable
     *
     * @return bool
     */
    public function isEnableDetails(): bool
    {
        return $this->helper->isEnable();
    }

    /**
     * Get Enable|Disable Shipping Address
     *
     * @return bool
     */
    public function isEnableShippingAddressDetails(): bool
    {
        return $this->helper->isEnableShippingAddress();
    }

    /**
     * Get Enable|Disable Shipping Method
     *
     * @return bool
     */
    public function isEnableShippingMethodDetails(): bool
    {
        return $this->helper->isEnableShippingMethod();
    }

    /**
     * Get Enable|Disable Order Status
     *
     * @return bool
     */
    public function isEnableOrderStatusDetails(): bool
    {
        return $this->helper->isEnableOrderStatus();
    }

    /**
     * Get Enable|Disable BiLLing Address
     *
     * @return bool
     */
    public function isEnableBillingAddressDetails(): bool
    {
        return $this->helper->isEnableBillingAddress();
    }

    /**
     * Get Enable|Disable Payment Method
     *
     * @return bool
     */
    public function isEnablePaymentMethodDetails(): bool
    {
        return $this->helper->isEnablePaymentMethod();
    }

    /**
     * Get Enable|Disable Product Details
     *
     * @return bool
     */
    public function isEnableOrderProductDetails(): bool
    {
        return $this->helper->isEnableOrderProduct();
    }

    /**
     * Get Format Price
     *
     * @param string $value
     * @return float|string
     */
    public function formatPrice(string $value)
    {
        return $this->formatPrice->currency($value, true, false);
    }

    /**
     * Format Shipping Address
     *
     * @return string
     */
    public function formatShipping()
    {
        $order = $this->getOrder();
        if ($order->getShippingAddress()) {
            return $this->render->format($order->getShippingAddress(), 'html');
        }
        return false;
    }

    /**
     * Format Billing Address
     *
     * @return string
     */
    public function formatBilling(): string
    {
        $order = $this->getOrder();
        return $this->render->format($order->getBillingAddress(), 'html');
    }

    /**
     * Format date
     *
     * @param string $date
     * @param string $format
     * @param bool $showTime
     * @param string $timezone
     * @param string|null $pattern
     * @return string
     */
    public function formatDate(
        $date = null,
        $format = IntlDateFormatter::SHORT,
        $showTime = false,
        $timezone = null,
        $pattern = 'd MMM Y'
    ): string {
        $date = $date instanceof DateTimeInterface;
        return $this->_localeDate->formatDateTime(
            $date,
            $format,
            $showTime ? $format : IntlDateFormatter::NONE,
            null,
            $timezone,
            $pattern
        );
    }

    /**
     * Return Options Configurable Product
     *
     * @param object $item
     * @return array
     */
    public function getItemOptions(object $item): array
    {
        $result = [];
        $option = $item->getProductOptions();
        if ($option) {
            if (isset($option['options'])) {
                $result = array_merge($result, $option['options']);
            }
            if (isset($option['additional_options'])) {
                $result = array_merge($result, $option['additional_options']);
            }
            if (isset($option['attributes_info'])) {
                $result = array_merge($result, $option['attributes_info']);
            }
        }
        return $result;
    }

    /**
     * Return Options Bundle Product
     *
     * @param object $item
     * @return array
     */
    public function getBundleItemOptions(object $item): array
    {
        $result = [];
        $option = $item->getProductOptions();
        if ($option) {
            if (isset($option['bundle_options'])) {
                $result = array_merge($result, $option['bundle_options']);
            }
        }
        return $result;
    }

    /**
     * Get Re-Order
     *
     * @return string
     */
    public function getReorder(): string
    {
        $order = $this->getOrder();
        $orderID = $order -> getId();
        return $this->getBaseUrl().'sales/order/view/order_id/'.$orderID;
    }

    /**
     * Get Print Order
     *
     * @return string
     */
    public function getPrint(): string
    {
        $order = $this->getOrder();
        $orderID = $order -> getId();
        return $this->getBaseUrl().'sales/order/print/order_id/'.$orderID;
    }

    /**
     * Can View Re-Order
     *
     * @return bool
     */
    public function canViewReorder(): bool
    {
        if ($this->helper->isEnableReOrderLink() && $this->helper->isEnableReOrder() && $this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * Can View Print Order
     *
     * @return bool
     */
    public function canViewPrint(): bool
    {
        if ($this->helper->isEnablePrintOrderLink() && $this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * Get Editor Details
     *
     * @return string
     * @throws Exception
     */
    public function getEditorDetails(): string
    {
        $description = $this->helper->isEditor();
        return  $description ? $this->filterProvider->getPageFilter()->filter($description) : '';
    }

    /**
     * Get Thanks Message
     *
     * @return string|null
     */
    public function getThankMessageDetails(): ?string
    {
        return $this->helper->getThankMessage()?: null;
    }

    /**
     * Get Thanks Message Size
     *
     * @return string|null
     */
    public function getThankMessageSizeDetails(): ?string
    {
        return $this->helper->getThankMessageSize();
    }

    /**
     * Get Thanks Message Color
     *
     * @return string|null
     */
    public function getThankMessageColorDetails(): ?string
    {
        return $this->helper->getThankMessageColor();
    }

    /**
     * Get Text Before Order
     *
     * @return string|null
     */
    public function getBeforeTextDetails(): ?string
    {
        return $this->helper->getBeforeText();
    }

    /**
     * Get Text Before Size
     *
     * @return string|null
     */
    public function getBeforeTextSizeDetails(): ?string
    {
        return $this->helper->getBeforeTextSize();
    }

    /**
     * Get Text Before Color
     *
     * @return string|null
     */
    public function getBeforeTextColorDetails(): ?string
    {
        return $this->helper->getBeforeTextColor();
    }

    /**
     * Get Text After Order
     *
     * @return string|null
     */
    public function getAfterTextDetails(): ?string
    {
        return $this->helper->getAfterText();
    }

    /**
     * Get Text After Size
     *
     * @return string|null
     */
    public function getAfterTextSizeDetails(): ?string
    {
        return $this->helper->getAfterTextSize();
    }

    /**
     * Get Text Before Color
     *
     * @return string|null
     */
    public function getAfterTextColorDetails(): ?string
    {
        return $this->helper->getAfterTextColor();
    }
}
