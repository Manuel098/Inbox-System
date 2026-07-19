import { AccountIcon } from "../../../../../components/ui";
import { GlobalBtn } from "../../../../../components/ui/btn";

const NewThreadButton = () => {
    return (
        <GlobalBtn icon={(props) => <AccountIcon size={20} className="text-blue-600 group-hover:text-blue-700 transition-colors duration-150" {...props} />} />
    );
};

export default NewThreadButton;