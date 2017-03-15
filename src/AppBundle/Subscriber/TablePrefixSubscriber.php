<?php

namespace AppBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;

class TablePrefixSubscriber implements EventSubscriber
{
    protected $prefix = '';

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /**
         * @var ClassMetadata $classMetadata
         */
        $classMetadata = $args->getClassMetadata();

        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            // if we are in an inheritance hierarchy, only apply this once
            return;
        }

        $classMetadata->setPrimaryTable([
            'name' => $this->prefix . $classMetadata->getTableName(),
        ]);

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == ClassMetadata::MANY_TO_MANY
                && array_key_exists('name', $classMetadata->associationMappings[$fieldName]['joinTable']) ) {
                // Check if "joinTable" exists, it can be null if this field is the reverse side of a ManyToMany relationship
                $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
            }
        }
    }
}