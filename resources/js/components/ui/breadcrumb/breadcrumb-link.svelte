<script lang="ts">
	import type { HTMLAnchorAttributes } from "svelte/elements";
	import { Link } from "@inertiajs/svelte";
	import type { Snippet } from "svelte";
	import type { WithElementRef } from "bits-ui";
	import { cn } from "@/utils.js";

	let {
		ref = $bindable(null),
		class: className,
		href = undefined,
		child,
		children,
		...restProps
	}: WithElementRef<HTMLAnchorAttributes> & {
		child?: Snippet<[{ props: HTMLAnchorAttributes }]>;
	} = $props();

	const attrs = $derived({
		class: cn("hover:text-foreground transition-colors", className),
		...restProps,
	});
</script>

{#if href}
	<Link {href} {...attrs}>
		{@render children?.()}
	</Link>
{:else if child}
	{@render child({ props: attrs })}
{/if}
