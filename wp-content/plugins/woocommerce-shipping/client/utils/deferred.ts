export const createDeferred = < T, R = T >() => {
	let resolve: ( value: T | PromiseLike< T > ) => void;
	let reject: ( reason?: unknown | R ) => void;

	const promise = new Promise< T >( ( res, rej ) => {
		resolve = res;
		reject = rej;
	} );

	return {
		promise,
		resolve: resolve!,
		reject: reject!,
	};
};
