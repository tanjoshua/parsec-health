<script>
	import { X } from "lucide-svelte";
	import Input from "./input.svelte";

	let {
		ref = $bindable(null),
		value = $bindable(),
		onCancel,
		...restProps
	} = $props();
</script>

<div class="relative">
	<Input bind:this={ref} bind:value {...restProps} />
	{#if onCancel}
		<div
			class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center h-full"
		>
			<button
				type="button"
				class="opacity-50 hover:opacity-100"
				onclick={onCancel}
			>
				<X size={20} />
			</button>
		</div>
	{/if}
</div>
