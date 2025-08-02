import { createRoot } from 'react-dom/client';
import ShippingSettings from 'components/shipping-settings';
import { registerSettingsStore } from 'data/settings';
import { camelCaseKeys, getConfig, initSentry } from 'utils';
import { registerAddressStore } from 'data/address';
import { registerCarrierStrategyStore } from 'data/carrier-strategy';

const domNode = document.getElementById( 'woocommerce-shipping-settings' );
const { origin_addresses: originAddresses } = getConfig();
const root = createRoot( domNode );
registerAddressStore( false );
registerSettingsStore();
registerCarrierStrategyStore();
initSentry();

root.render(
	<ShippingSettings
		originAddresses={ originAddresses.map( camelCaseKeys ) }
	/>
);
