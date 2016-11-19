<?php
/**
 * @author Tom Needham <tom@owncloud.com>
 *
 * @copyright Copyright (c) 2016, ownCloud GmbH.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Settings\Panels\Admin;

use OCP\Settings\IPanel;
use OCP\Template;

class Encryption implements IPanel {

    public function getPriority() {
        return 0;
    }

    public function getPanel() {
        $tmpl = new Template('settings', 'panels/admin/encryption');
		$tmpl->assign('encryptionEnabled', \OC::$server->getEncryptionManager()->isEnabled());
		$tmpl->assign('encryptionReady', \OC::$server->getEncryptionManager()->isReady());
		$encryptionModules = \OC::$server->getEncryptionManager()->getEncryptionModules();
		$defaultEncryptionModuleId = \OC::$server->getEncryptionManager()->getDefaultEncryptionModuleId();
		$encModulues = [];
		foreach ($encryptionModules as $module) {
			$encModulues[$module['id']]['displayName'] = $module['displayName'];
			$encModulues[$module['id']]['default'] = false;
			if ($module['id'] === $defaultEncryptionModuleId) {
				$encModulues[$module['id']]['default'] = true;
			}
		}
		$backends = \OC::$server->getUserManager()->getBackends();
		$externalBackends = (count($backends) > 1) ? true : false;
		$tmpl->assign('externalBackendsEnabled', $externalBackends);

		$tmpl->assign('encryptionModules', $encModulues);
        return $tmpl;
    }

    public function getSectionID() {
        return 'general';
    }

}
