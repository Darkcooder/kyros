<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die;

?>

<article class="col3"> <?php echo $this->item->event->BeforeDisplay; ?> <?php echo $this->item->event->K2BeforeDisplay; ?>
          <?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
          <div class="itemImageBlock"> <a class="itemImage" href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
                    <img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
                    </a></div>
          <?php endif; ?>
          <?php if($this->item->params->get('latestItemTitle')): ?>
          <header>
                    <h2>
                              <?php if ($this->item->params->get('latestItemTitleLinked')): ?>
                              <a href="<?php echo $this->item->link; ?>"><?php echo $this->item->title; ?></a>
                              <?php else: ?>
                              <?php echo $this->item->title; ?>
                              <?php endif; ?>
                    </h2>
          </header>
          <?php endif; ?>
          <?php echo $this->item->event->AfterDisplay; ?> <?php echo $this->item->event->K2AfterDisplay; ?> </article>
