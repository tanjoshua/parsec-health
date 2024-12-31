<script lang="ts">
    import dayjs from "dayjs";
    import { Clock } from "lucide-svelte";
    import { Button } from "../ui/button";
    import { onMount } from "svelte";
    const props = $props<{
        now: Date;
    }>();

    const HOUR_BLOCK_HEIGHT_PX = 120;

    let scheduleContainer: HTMLDivElement;

    function indexToTime(index: number): string {
        const hour = index % 12 || 12;
        const period = index < 12 ? "AM" : "PM";
        return `${hour} ${period}`;
    }

    onMount(() => {
        scrollToCurrentTime();
    });

    function scrollToCurrentTime() {
        if (scheduleContainer) {
            const currentTimePosition =
                (dayjs(props.now).hour() + dayjs(props.now).minute() / 60) *
                HOUR_BLOCK_HEIGHT_PX;
            const containerHeight = scheduleContainer.clientHeight;
            const scrollPosition = currentTimePosition - containerHeight / 2;
            scheduleContainer.scrollTop = scrollPosition;
        }
    }
</script>

<div class="rounded-md border p-4 h-full">
    <div>
        <div class="text-2xl font-bold text-center" aria-live="polite">
            {dayjs(props.now).format("h:mm A")}
        </div>
        <div class="text-lg text-center text-muted-foreground">
            {dayjs(props.now).format("dddd, MMMM D, YYYY")}
        </div>
    </div>

    <div class="mt-4 flex justify-between items-center min-h-9">
        <div class="text-lg font-semibold">Today's Schedule</div>
        <Button onclick={scrollToCurrentTime} size="sm" variant="outline">
            <Clock />
            Now
        </Button>
    </div>

    <div
        class="mt-4 relative min-h-[480px] overflow-y-auto scroll-smooth"
        bind:this={scheduleContainer}
    >
        {#each Array.from({ length: 24 }, (_, i) => i) as hour}
            <div
                class="absolute w-full border-t text-xs text-muted-foreground"
                style="top: {hour * HOUR_BLOCK_HEIGHT_PX}px"
            >
                {indexToTime(hour)}
            </div>
        {/each}
        <div
            class="absolute w-full border-t-2 border-red-500 text-xs text-red-500 font-semibold"
            style="top: {(dayjs(props.now).hour() +
                dayjs(props.now).minute() / 60) *
                HOUR_BLOCK_HEIGHT_PX}px"
        >
            {dayjs(props.now).format("h:mm A")}
        </div>
    </div>
</div>
