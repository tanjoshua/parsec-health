<script lang="ts">
	import type { HTMLInputAttributes } from "svelte/elements";
	import type { WithElementRef } from "bits-ui";
	import { cn } from "@/utils.js";
	import { Label } from "@/components/ui/label";
	import Input from "./input.svelte";

	let {
		ref = $bindable(null),
		value = $bindable(),
		class: className,
		label,
		...restProps
	}: WithElementRef<HTMLInputAttributes> & {
		label?: string;
	} = $props();
</script>

<div class="grid gap-1.5">
	{#if label}
		<Label for={restProps.id}>{label}</Label>
	{/if}
	<Input {ref} class={className} bind:value {...restProps} />
</div>
