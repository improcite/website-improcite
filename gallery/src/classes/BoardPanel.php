<?php
/**
 * This file implements the class BoardPanel.
 * 
 * PHP versions 4 and 5
 *
 * LICENSE:
 * 
 * This file is part of PhotoShow.
 *
 * PhotoShow is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PhotoShow is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PhotoShow.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright 2011 Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */

/**
 * BoardPanel
 *
 * Implements the displaying of multiple components:
 * a Menu, and a Board.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */
class BoardPanel implements HTMLObject
{
	/// Board to display
	private $board;
	
	/// Boards panel class depending on layout (image|boards)
	private $boards_class;
	
	/// Used to display the rights of current dir
	private $judge;

	/**
	 * Create BoardPanel
	 *
	 * @param string $dir 
	 * @author Thibaud Rohmer
	 */
	public function __construct($dir){
		
		/// Board
		$this->board	=	new Board($dir);
		
		/// Check layout
		if(is_file(CurrentUser::$path)){
			$this->boards_class	=	"boards_panel_image";
		}else{
			$this->boards_class 	=	"boards_panel_thumbs";
		}

		if(CurrentUser::$admin){
			$this->judge	=	new Judge($dir);
		}
	}

	/**
	 * Display BoardPanel on website
	 *
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public function toHTML(){

		/// Display Boards
		$this->board->toHTML();
	}
}