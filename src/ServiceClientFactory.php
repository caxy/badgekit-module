<?php

namespace Drupal\badgekit;

use Caxy\BadgeKit\ServiceClient;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;

class ServiceClientFactory
{
    private $config_factory;

    /**
     * ServiceClientFactory constructor.
     * @param ConfigFactoryInterface $config_factory
     */
    public function __construct(ConfigFactoryInterface $config_factory) {
        $this->config_factory = $config_factory;
    }

    public function create(ClientInterface $client)
    {
        $config = $this->config_factory->get('badgekit.settings');
        $serviceClient = new ServiceClient($client, [
          'system' => $config->get('system'),
          'issuer' => $config->get('issuer'),
          'program' => $config->get('program'),
        ]);
        return $serviceClient;
    }
}
