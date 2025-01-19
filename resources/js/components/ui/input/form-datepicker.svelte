<script lang="ts">
	import CalendarIcon from "lucide-svelte/icons/calendar";
	import { DateFormatter, getLocalTimeZone } from "@internationalized/date";
	import { Button } from "@/components/ui/button/index.js";
	import { Calendar } from "@/components/ui/calendar/index.js";
	import * as Popover from "@/components/ui/popover/index.js";
	import { cn } from "@/utils";
	import type { WithElementRef } from "bits-ui";
	import type { HTMLInputAttributes } from "svelte/elements";
	import { Label } from "../label";

	const df = new DateFormatter("en-US", {
		dateStyle: "long",
	});

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
	<Popover.Root>
		<Popover.Trigger>
			{#snippet child({ props })}
				<Button
					variant="outline"
					class={cn(
						"w-[240px] justify-start text-left font-normal",
						!value && "text-muted-foreground",
					)}
					{...props}
				>
					<CalendarIcon />
					{value
						? df.format(value.toDate(getLocalTimeZone()))
						: "Pick a date"}
				</Button>
			{/snippet}
		</Popover.Trigger>
		<Popover.Content class="w-auto p-0" align="start">
			<Calendar type="single" bind:value />
		</Popover.Content>
	</Popover.Root>
</div>
