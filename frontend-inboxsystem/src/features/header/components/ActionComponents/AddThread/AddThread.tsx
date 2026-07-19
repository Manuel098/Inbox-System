import { PlusIcon } from "../../../../../components/ui";
import { GlobalBtn } from "../../../../../components/ui/btn";

const NewThreadButton = () => {
    return (
        <GlobalBtn icon={(props) => <PlusIcon size={20} className="text-emerald-500 group-hover:text-emerald-600 transition-colors" {...props} />} />
    );
};

export default NewThreadButton;