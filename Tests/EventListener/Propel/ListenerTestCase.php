<?php

namespace Vich\UploaderBundle\Tests\EventListener\Propel;

use Vich\UploaderBundle\Tests\DummyEntity;

/**
 * Propel listener test case.
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class ListenerTestCase extends \PHPUnit_Framework_TestCase
{
    const FIELD_NAME = 'file';
    const MAPPING_NAME = 'mapping_name';

    /**
     * @var \Vich\UploaderBundle\Adapter\AdapterInterface $adapter
     */
    protected $adapter;

    /**
     * @var \Vich\UploaderBundle\Handler\UploadHandler $handler
     */
    protected $handler;

    /**
     * @var MetadataReader $metadata
     */
    protected $metadata;

    /**
     * @var PropelUploaderListener $listener
     */
    protected $listener;

    /**
     * @var EventArgs
     */
    protected $event;

    /**
     * @var DummyEntity
     */
    protected $object;

    /**
     * Sets up the test
     */
    public function setUp()
    {
        $this->adapter = $this->getAdapterMock();
        $this->handler = $this->getHandlerMock();
        $this->object = new DummyEntity();
        $this->event = $this->getEventMock();
        $this->metadata = $this->getMetadataReaderMock();

        // the adapter is always used to return the object
        $this->adapter
            ->expects($this->any())
            ->method('getObjectFromArgs')
            ->with($this->event)
            ->will($this->returnValue($this->object));

        $this->metadata
            ->expects($this->any())
            ->method('getUploadableFields')
            ->with('Vich\UploaderBundle\Tests\DummyEntity', self::MAPPING_NAME)
            ->will($this->returnValue(array(
                array('propertyName' => self::FIELD_NAME)
            )));
    }

    /**
     * Creates a mock adapter.
     *
     * @return \Vich\UploaderBundle\Adapter\AdapterInterface The mock adapter.
     */
    protected function getAdapterMock()
    {
        return $this->getMock('Vich\UploaderBundle\Adapter\AdapterInterface');
    }

    /**
     * Creates a mock handler.
     *
     * @return \Vich\UploaderBundle\Handler\UploadHandler The handler mock.
     */
    protected function getHandlerMock()
    {
        return $this->getMockBuilder('Vich\UploaderBundle\Handler\UploadHandler')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Creates a mock event.
     *
     * @return \Symfony\Component\EventDispatcher\GenericEvent The mock event.
     */
    protected function getEventMock()
    {
        return $this->getMockBuilder('\Symfony\Component\EventDispatcher\GenericEvent')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Creates a mock metadata reader.
     *
     * @return \Vich\UploaderBundle\Metadata\MetadataReader The mock metadata reader.
     */
    protected function getMetadataReaderMock()
    {
        return $this->getMockBuilder('Vich\UploaderBundle\Metadata\MetadataReader')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
