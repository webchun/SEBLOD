<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: promotion.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				http://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2016 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// JCckEcommercePromotion
abstract class JCckEcommercePromotion
{
	// apply
	public static function apply( $type, &$total, $params = array() )
	{
		$user		=	JCck::getUser();
		$my_groups	=	$user->groups; /* $user->getAuthorisedGroups(); */
		
		$currency	=	JCckEcommerce::getCurrency();
		$promotions	=	JCckEcommerce::getPromotions( $type );
		$res		=	0;
		$results	=	array( 'items'=>array() );
		$text		=	'';
		
		if ( count( $promotions ) ) {
			foreach ( $promotions as $p ) {
				if ( isset( $params['target'] ) && $params['target'] ) {
					if ( $params['target'] == 'order' && $p->target == 0 ) {
						// OK
					} elseif ( $params['target'] == 'product' ) {
						if ( $p->target == 1 ) {
							// OK
						} elseif ( $p->target == 2 ) {
							$products	=	self::getTargets( $p->id );

							if ( !isset( $products[$params['target_id']] ) ) {
								continue;
							}
						} elseif ( $p->target == -2 ) {
							$products	=	self::getTargets( $p->id );
							
							if ( isset( $products[$params['target_id']] ) ) {
								continue;
							}
						} else {
							continue;
						}
					} else {
						continue;
					}
				}
				if ( $p->type == 'coupon' ) {
					if ( $p->code && ( $p->code != @$params['code'] ) ) {
						continue;
					}
				}
				$groups		=	explode( ',', $p->groups );

				if ( count( array_intersect( $my_groups, $groups ) ) > 0 ) {
					switch ( $p->discount ) {
						case 'free':
							$promotion			=	0;
							$res				=	$promotion;
							$text				=	JText::_( 'COM_CCK_FREE' );
							$total				=	$promotion;
							$results['items'][$p->id]	=	array( 'type'=>$p->type, 'promotion'=>$p->discount, 'promotion_amount'=>'', 'text'=>$text, 'title'=>$p->title, 'code'=>@(string)$params['code'] );
							break;
						case 'minus':
							$promotion			=	$p->discount_amount * -1;
							$res				+=	$promotion;
							$text				=	'- '.JCckEcommerceCurrency::format( $p->discount_amount );
							$total				+=	$promotion;
							$total				=	( $total < 0 ) ? 0 : $total;
							$results['items'][$p->id]	=	array( 'type'=>$p->type, 'promotion'=>$p->discount, 'promotion_amount'=>(string)$promotion, 'text'=>$text, 'title'=>$p->title, 'code'=>@(string)$params['code'] );
							break;
						case 'percentage':
							$promotion			=	$total * $p->discount_amount / 100;
							$res				=	$promotion;
							$text				=	'- '.$p->discount_amount.' %';
							$total				=	$total - $promotion;
							$results['items'][$p->id]	=	array( 'type'=>$p->type, 'promotion'=>$p->discount, 'promotion_amount'=>(string)$promotion, 'text'=>$text, 'title'=>$p->title, 'code'=>@(string)$params['code'] );
							break;
						case 'set':
							$promotion			=	$total - $p->discount_amount;
							$res				=	$promotion;
							$text				=	'"'.JCckEcommerceCurrency::format( $p->discount_amount ).'"';
							$total				=	$total - $promotion;
							$results['items'][$p->id]	=	array( 'type'=>$p->type, 'promotion'=>$p->discount, 'promotion_amount'=>(string)$promotion, 'text'=>$text, 'title'=>$p->title, 'code'=>@(string)$params['code'] );
						default:
							break;
					}
				}
			}
		}

		if ( $res ) {
			$results['text']	=	$text;
			$results['total']	=	(float)$res;

			return (object)$results;
		}

		return null;
	}

	// count
	public static function count( $type )
	{	
		return count( JCckEcommerce::getPromotions( $type ) );
	}

	// getTargets
	public static function getTargets( $id )
	{
		static $cache	=	array();

		if ( !isset( $cache[$id] ) ) {
			$cache[$id]	=	JCckDatabase::loadColumn( 'SELECT product_id FROM #__cck_more_ecommerce_promotion_product WHERE promotion_id = '.(int)$id );
			$cache[$id]	=	array_flip( $cache[$id] );
		}

		return $cache[$id];
	}
}
?>