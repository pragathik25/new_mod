<?php

namespace Drupal\new_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
  * Provides simple block for d4drupal.
  * @Block (
  * id = "new_module",
  * admin_label = "Custom Plugin Block"
  * )
  */


class CustomPluginBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * @var AccountInterface $account
     */
protected $account;
/**
 * @param array $configuration
 * @param string $plugin_id
 * @param mixed $plugin_definition
 * @param Drupal\Core\Session\AccountInterface $account
 */

public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $account;
}


/**
 * {@inheritdoc}
 */

public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('current_user')
    );
}

    /**
     * {@inheritdoc}
     */
    public function build() { // render function
        $text = $this->configuration['text'];
        $text1 = $this->configuration['text1'];
        return [
            "#markup" => $text . " " . $this->account->getAccountName() ." " . $text1 ,
        ];
    }


    public function defaultConfiguration() {
        return [
        'text' => "welcome",
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form['text'] = [
            '#type' => 'textfield',
            '#title' => 'Text',
            '#default_value' => $this->configuration['text'],
        ];
        $form['text1'] = [
            '#type' => 'textfield',
            '#title' => 'Text1',
            '#default_value' => $this->configuration['text1'],
        ];
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['text'] = $form_state->getValue('text');
        $this->configuration['text1'] = $form_state->getValue('text1');

    }


    /**
     * {@inheritdoc}
     */

    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, "permission for block plugin");
    }

}

