<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DGIAMPOR
 * Date: 25/03/13
 * Time: 14:49
 * To change this template use File | Settings | File Templates.
 */

namespace Sondage\AuthenticatedUserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'sondage_user_registration';
    }
}