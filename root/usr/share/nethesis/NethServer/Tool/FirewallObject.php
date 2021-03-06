<?php

namespace NethServer\Tool;

/*
 * Copyright (C) 2014  Nethesis S.r.l.
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TODO: add component description here
 *
 * @author Davide Principi <davide.principi@nethesis.it>
 * @since 1.0
 */
class FirewallObject
{

    /**
     *
     * @param string $key
     * @param string $type
     * @param array $props
     * @param callable $translator
     */
    public function __construct($key, $type, $props, $translator = NULL)
    {
        $this->key = $key;
        $this->type = $type;
        $this->props = $props;
        $this->props['key'] = $key;
        $this->props['type'] = $type;

        $this->T = ! is_callable($translator) ? function($x, $args = array()) {
            return sprintf("%s %s", ucfirst($args['type']), $args['key']);
        } : $translator;
    }

    public function setTranslator($T)
    {
        $this->T = $T;
        return $this;
    }

    public function getValue()
    {
        if ($this->getType() === 'raw') {
            return $this->key;
        }
        return sprintf('%s;%s', $this->getType(), $this->key);
    }

    public function getTitle()
    {        
        return call_user_func($this->T, sprintf("FirewallObject_%s_Title", $this->type), $this->props);
    }

    public function getShortTitle()
    {
        return $this->key;
    }

    public function getDetails()
    {
        return isset($this->props['Description']) ? $this->props['Description'] : '';
    }

    public function getType()
    {        
        if ($this->type === 'remote') {
            return 'host';
        } elseif ($this->type === 'local') {
            return 'host';
        }
        return $this->type;
    }

}