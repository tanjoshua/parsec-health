<script lang="ts">
	import type { Visit } from "@/types/visit";
	import dayjs from "dayjs";
	let {
		now,
		selectedVisit = $bindable(),
	}: {
		now: Date;
		selectedVisit: Visit | null;
	} = $props();

	let patientMetadata = $derived.by(() => {
		if (!selectedVisit?.customer.metadata) return {};
		return JSON.parse(selectedVisit.customer.metadata);
	});
</script>

<div class="rounded-md border h-full">
	<div class="p-4">
		<div class="text-2xl font-bold text-center" aria-live="polite">
			{dayjs(now).format("h:mm:ss A")}
		</div>
		<div class="text-lg text-center text-muted-foreground">
			{dayjs(now).format("dddd, MMMM D, YYYY")}
		</div>
	</div>
	<div>
		{#if selectedVisit}
			<div class="border-t p-4">
				<div class="text-sm text-muted-foreground">
					#{selectedVisit.customer.tenant_customer_number}
				</div>
				<div class="font-semibold">{selectedVisit.customer.name}</div>
				<div class="mt-2 grid grid-cols-4 gap-2">
					{#each Object.entries(patientMetadata) as [key, value]}
						<div class="grid gap-1">
							<div class="text-xs text-muted-foreground">
								{key}
							</div>
							<div class="text-sm">{value}</div>
						</div>
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
