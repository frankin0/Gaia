<?php 

namespace Gaia\core\config;

/*
 * How - The program that powers espoweb.com
 * Copyright (C) 2017
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * https://espoweb.com
 *
 */

class Requests{

    public $_body;
    private $_rawBody;
    private $_method;
    private $_header;

    public function __construct(){
        $this->_body = array();
    }

    public function getBody(){
        return $this->_body != null
            ? $this->_body
            : $this->_rawBody;
    }

    public function getMethod(){
        return $this->_method;
    }

    /**
     * Sets the request body.
     *
     * @param RequestData|string $body
     */
    public function setBody($body): void {
        if ($body instanceof RequestData) {
            $this->_rawBody = null;
            $this->_body = $body;
        } else {
            $this->_body = null;
            $this->_rawBody = $body;
        }
    }

    public function setMethod(int $type):void {
        $this->_method = $type;
    }

    /**
     * Returns the request headers.
     *
     * @return RequestHeader
     */
    public function getHeader(): RequestHeader{
        return $this->_header;
    }

    /**
     * Set the request headers.
     *
     * @param RequestHeader $header
     */
    public function setHeader(RequestHeader $header): void{
        $this->_header = $header;
    }

}