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

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Options;

class TranslatableChoiceType extends ChoiceType
{
    protected $translator;

    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param array $options
     * @return array
     */
    public function getDefaultOptions()
    {
        return array(
            'multiple'          => false,
            'expanded'          => false,
            'choice_list'       => null,
            'choices'           => array(),
            'preferred_choices' => array(),
            'catalogue'         => 'messages',
            'empty_data'        => function (Options $options, $previousValue) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded ? array() : '';
            },
            'empty_value'       => function (Options $options, $previousValue) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded || !isset($options['empty_value']) ? null : '';
            },
            'error_bubbling'    => false,
        );
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        // translate options before building form
        foreach ($options['choices'] as $name => $value) {
            $options['choices'][$name] = $this->translator->trans($value, array(), $options['catalogue']);
        }

        // translate empty value
        if (!empty($options['empty_value'])) {
            $options['empty_value'] = $this->translator->trans($options['empty_value'], array(), $options['catalogue']);
        }

        parent::buildForm($builder, $options);
    }
}
