<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Feature\InstallService;
use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServiceManifest extends ModelManifest
{

    public function getPages()
    {
        return [
            'index'   => [
                'navigation' => true,
                'icon' => 'cogs',
                'title'      => 'Services',
                'route'      => 'acp@supreme::services.index',
                'url'        => 'supreme/services',
                'handler'    => function (TableBuilder $builder) {
                    $builder->setModel(ServiceModel::class)
                            ->setButtons(['edit','delete']);

                    return $builder->render();
                },
                'buttons'    => [
                    'create',
                ],
            ],
            'create'  => [
                'title'      => 'New Service',
                'route'      => 'acp@supreme::services.create',
                'url'        => 'supreme/services/create',
                'handler'    => function (FormBuilder $builder, ServiceModel $service) {
                    return $builder->render($service);
                },
                'buttons'    => [
                    'index',
                ],
            ],
            'install' => [
                'url'     => 'supreme/services/{id}/install',
                'handler' => InstallService::class . "@handle",
            ],
            'edit'    => [
                'title'   => 'Edit Service',
                'route'   => 'acp@supreme::service.edit',
                'url'     => 'supreme/services/{id}/edit',
                'handler' => function (FormBuilder $builder, Services $services, $id) {
                    return $builder->render($services->find($id));
                },
                'buttons' => [
                    'create',
                    'delete'      => ['confirm' => true],
                    'install_dns' => [
                        'text'  => 'Install Server',
                        'href'  => 'supreme/services/{entry.id}/install',
                        'class' => 'remote',
                    ],
                ],
            ],
        ];
    }
}