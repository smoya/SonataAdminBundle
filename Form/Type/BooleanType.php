<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\AdminBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType as FormChoiceType;
use Symfony\Component\Translation\TranslatorInterface;

class BooleanType extends FormChoiceType
{
    const TYPE_YES = 1;

    const TYPE_NO = 2;

    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getDefaultOptions()
    {
        $expanded = $options['expanded'] == true;
        $options = parent::getDefaultOptions($options);

        $options['choices'] = array(
            ($expanded ? true : self::TYPE_YES)  => $this->translator->trans('label_type_yes', array(), 'SonataAdminBundle'),
            ($expanded ? false : self::TYPE_NO)   => $this->translator->trans('label_type_no', array(), 'SonataAdminBundle'),
        );

        return $options;
    }
}