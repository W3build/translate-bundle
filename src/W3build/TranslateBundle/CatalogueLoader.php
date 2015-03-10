<?php
/**
 * Created by PhpStorm.
 * User: Jahodal
 * Date: 15.2.14
 * Time: 21:40
 */

namespace W3build\TranslateBundle;

use \Symfony\Component\Translation\Loader\LoaderInterface;
use \Doctrine\ORM\EntityManager;
use \Doctrine\Common\Cache\ApcCache;
use Symfony\Component\Translation\MessageCatalogue;

class CatalogueLoader implements LoaderInterface {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_entityManager = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function load($resource, $locale, $domain = 'messages'){

        $catalogue = new MessageCatalogue($locale);

        if($locale = $this->_entityManager->getRepository('W3buildTranslateBundle:Locale')->findByCode($locale)){
            $translations = $locale->getTranslations();

            foreach ($translations as $translation) {
                $catalogue->set($translation->getMsgId()->getMsgId(), $translation->getMsgStr());
            }
        }


        return $catalogue;

    }

} 