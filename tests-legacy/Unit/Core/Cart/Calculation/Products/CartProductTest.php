<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace LegacyTests\Unit\Core\Cart\Calculation\Products;

use LegacyTests\Unit\Core\Cart\Calculation\AbstractCartCalculationTest;

/**
 * behat equivalent : Scenarii/Cart/Calculation/Product/only_products.feature
 */
class CartProductTest extends AbstractCartCalculationTest
{
    /**
     * @dataProvider cartWithoutCartRulesProvider
     */
    public function testCartWithoutCartRules($productData, $expectedTotal, $cartRuleData)
    {
        $this->resetCart();
        $this->addProductsToCart($productData);
        $this->addCartRulesToCart($cartRuleData);
        $this->compareCartTotalTaxIncl($expectedTotal);
    }

    public function cartWithoutCartRulesProvider()
    {
        return array(
            'empty cart'                             => array(
                'products'      => array(),
                'expectedTotal' => 0,
                'cartRules'     => array(),
            ),
            'one product in cart, quantity 1'        => array(
                'products'      => array(1 => 1),
                'expectedTotal' => static::PRODUCT_FIXTURES[1]['price']
                + static::DEFAULT_SHIPPING_FEE + static::DEFAULT_WRAPPING_FEE,
                'cartRules'     => array(),
            ),
            'one product in cart, quantity 3'        => array(
                'products'      => array(1 => 3),
                'expectedTotal' => 3 * static::PRODUCT_FIXTURES[1]['price']
                + static::DEFAULT_SHIPPING_FEE + static::DEFAULT_WRAPPING_FEE,
                'cartRules'     => array(),
            ),
            '3 products in cart, several quantities' => array(
                'products'      => array(
                    2 => 2,
                    1 => 3,
                    3 => 1,
                ),
                'expectedTotal' => 3 * static::PRODUCT_FIXTURES[1]['price']
                + 2 * static::PRODUCT_FIXTURES[2]['price']
                + static::PRODUCT_FIXTURES[3]['price']
                + static::DEFAULT_SHIPPING_FEE + static::DEFAULT_WRAPPING_FEE,
                'cartRules'     => array(),
            ),
        );
    }
}
