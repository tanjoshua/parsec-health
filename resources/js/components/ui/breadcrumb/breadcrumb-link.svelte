<script lang="ts">
	import type { HTMLAnchorAttributes } from "svelte/elements";
	import type { Snippet } from "svelte";
	import type { WithElementRef } from "bits-ui";
	import { cn } from "@/utils.js";
	import { Link } from "@inertiajs/svelte";

	let {
		ref = $bindable(null),
		class: className,
		href = "",
		child,
		children,
		...restProps
	}: WithElementRef<HTMLAnchorAttributes> & {
		child?: Snippet<[{ props: HTMLAnchorAttributes }]>;
	} = $props();

	const attrs = $derived({
		class: cn("hover:text-foreground transition-colors", className),
		href,
		...restProps,
	});
</script>

{#if child}
	{@render child({ props: attrs })}
{:else}
	<Link href={href as string}>
		{@render children?.()}
	</Link>
{/if}
